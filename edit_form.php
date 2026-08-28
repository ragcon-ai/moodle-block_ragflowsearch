<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Per-instance configuration form for the RAGflow search block.
 *
 * @package    block_ragflowsearch
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Block instance settings: which RAGflow knowledge base(s) to search and with which scope.
 * Restricted to site administrators (enforced again on save in the block class).
 */
class block_ragflowsearch_edit_form extends block_edit_form {
    /**
     * Add the block-specific settings.
     *
     * @param MoodleQuickForm $mform
     */
    protected function specific_definition($mform): void {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Only site administrators may choose the knowledge base / scope.
        if (!is_siteadmin()) {
            $mform->addElement(
                'static',
                'adminonly',
                '',
                get_string('adminonly', 'block_ragflowsearch')
            );
            return;
        }

        // The RAGflow provider must be enabled (it supplies the datasets + credentials).
        [$prov, $conf] = self::provider();
        if (!$prov) {
            $mform->addElement(
                'static',
                'nodatasets',
                '',
                get_string('nodatasets', 'block_ragflowsearch')
            );
            return;
        }

        // Searchable, tag-style multi-select with an AJAX source (the same 'autocomplete' element Moodle
        // uses e.g. for enrolling users): each keystroke queries the server for matching knowledge bases,
        // so it scales without preloading the whole list. Only the already-selected datasets are passed
        // as options here, so their names render when editing an existing block.
        $options = self::selected_labels((array) ($this->block->config->datasets ?? []), $prov, $conf);
        $mform->addElement(
            'autocomplete',
            'config_datasets',
            get_string('config_datasets', 'block_ragflowsearch'),
            $options,
            [
                'multiple' => true,
                'ajax' => 'aiprovider_ragflow/form_dataset_selector',
                'noselectionstring' => get_string('config_datasets_none', 'block_ragflowsearch'),
            ]
        );
        $mform->setType('config_datasets', PARAM_ALPHANUMEXT);
        $mform->addHelpButton('config_datasets', 'config_datasets', 'block_ragflowsearch');

        // Search scope: the whole knowledge base, or only documents of the current course (metadata).
        $mform->addElement(
            'select',
            'config_scope',
            get_string('config_scope', 'block_ragflowsearch'),
            [
                'all' => get_string('scope:all', 'block_ragflowsearch'),
                'course' => get_string('scope:course', 'block_ragflowsearch'),
            ]
        );
        $mform->setType('config_scope', PARAM_ALPHA);
        $mform->setDefault('config_scope', 'all');
        $mform->addHelpButton('config_scope', 'config_scope', 'block_ragflowsearch');

        // The document metadata field holding the Moodle course id (only used for the course scope).
        $mform->addElement(
            'text',
            'config_coursefield',
            get_string('config_coursefield', 'block_ragflowsearch'),
            ['size' => 30]
        );
        $mform->setType('config_coursefield', PARAM_ALPHANUMEXT);
        $mform->setDefault('config_coursefield', 'course_id');
        $mform->addHelpButton('config_coursefield', 'config_coursefield', 'block_ragflowsearch');
        $mform->hideIf('config_coursefield', 'config_scope', 'neq', 'course');

        // Optional RAGflow rerank model, chosen from the tenant's available rerank models. Empty = no
        // reranking (plain vector/keyword ranking). When set, RAGflow reorders the retrieved candidates by
        // a cross-encoder for much better precision. The other quality controls (relevance floor, media
        // floor, result cap) use sensible defaults and need no configuration. If RAGflow has no rerank
        // model configured, a hint is shown instead of the selector.
        $rerankers = \aiprovider_ragflow\helper::rerank_models(
            (string) ($conf['baseurl'] ?? ''),
            (string) ($conf['apikey'] ?? '')
        );
        if (!empty($rerankers)) {
            // Keep a previously stored value selectable even if it is no longer in the list.
            $current = trim((string) ($this->block->config->rerankmodel ?? ''));
            if ($current !== '' && !isset($rerankers[$current])) {
                $rerankers[$current] = $current;
            }
            $options = ['' => get_string('config_rerankmodel_none', 'block_ragflowsearch')] + $rerankers;
            $mform->addElement(
                'select',
                'config_rerankmodel',
                get_string('config_rerankmodel', 'block_ragflowsearch'),
                $options
            );
            $mform->setType('config_rerankmodel', PARAM_RAW_TRIMMED);
            $mform->setDefault('config_rerankmodel', '');
            $mform->addHelpButton('config_rerankmodel', 'config_rerankmodel', 'block_ragflowsearch');
        } else {
            $mform->addElement(
                'static',
                'rerankunavailable',
                get_string('config_rerankmodel', 'block_ragflowsearch'),
                get_string('config_rerankmodel_unavailable', 'block_ragflowsearch')
            );
        }

        // Result-quality knobs (sensible defaults; tune per block). Minimum relevance is the main filter;
        // the relevance cliff cuts the list once scores fall away from the best hit (0 = off); the cap
        // bounds the number of text results. Images/media keep their own, lower floor.
        $mform->addElement(
            'text',
            'config_minsimilarity',
            get_string('config_minsimilarity', 'block_ragflowsearch'),
            ['size' => 8]
        );
        $mform->setType('config_minsimilarity', PARAM_FLOAT);
        $mform->setDefault('config_minsimilarity', 0.35);
        $mform->addHelpButton('config_minsimilarity', 'config_minsimilarity', 'block_ragflowsearch');

        $mform->addElement('text', 'config_maxresults', get_string('config_maxresults', 'block_ragflowsearch'), ['size' => 8]);
        $mform->setType('config_maxresults', PARAM_INT);
        $mform->setDefault('config_maxresults', 5);
        $mform->addHelpButton('config_maxresults', 'config_maxresults', 'block_ragflowsearch');

        $mform->addElement('text', 'config_cliffratio', get_string('config_cliffratio', 'block_ragflowsearch'), ['size' => 8]);
        $mform->setType('config_cliffratio', PARAM_FLOAT);
        $mform->setDefault('config_cliffratio', 0.6);
        $mform->addHelpButton('config_cliffratio', 'config_cliffratio', 'block_ragflowsearch');

        // Semantic vs. keyword balance for the hybrid retrieval. RAGflow's default (0.3) is keyword-heavy:
        // single keywords match well, but full-sentence questions score poorly (their function words
        // dilute the keyword match). A higher weight lets the semantic vector dominate, so questions asked
        // in sentence form match by meaning. Default: 0.7.
        $mform->addElement('text', 'config_vectorweight', get_string('config_vectorweight', 'block_ragflowsearch'), ['size' => 8]);
        $mform->setType('config_vectorweight', PARAM_FLOAT);
        $mform->setDefault('config_vectorweight', 0.7);
        $mform->addHelpButton('config_vectorweight', 'config_vectorweight', 'block_ragflowsearch');
    }

    /**
     * The enabled RAGflow provider instance and its decoded config, or [null, []] if none / helper absent.
     *
     * @return array [stdClass|null $provider, array $config]
     */
    protected static function provider(): array {
        global $DB;
        if (!class_exists('\aiprovider_ragflow\helper')) {
            return [null, []];
        }
        $prov = $DB->get_record_select(
            'ai_providers',
            'provider = :p AND enabled = 1',
            ['p' => 'aiprovider_ragflow\\provider'],
            '*',
            IGNORE_MULTIPLE
        );
        if (!$prov) {
            return [null, []];
        }
        return [$prov, json_decode($prov->config, true) ?: []];
    }

    /**
     * Names ([id => name]) of the already-selected datasets, so the autocomplete can render them when
     * editing an existing block. Returns [] for a fresh block (nothing selected -> no lookup needed).
     *
     * @param array $selected Selected dataset ids.
     * @param stdClass $prov Enabled provider record.
     * @param array $conf Decoded provider config.
     * @return array
     */
    protected static function selected_labels(array $selected, $prov, array $conf): array {
        $selected = array_values(array_filter(array_map('strval', $selected)));
        if (empty($selected)) {
            return [];
        }
        $all = \aiprovider_ragflow\helper::datasets_cached(
            (int) $prov->id,
            (string) ($conf['baseurl'] ?? ''),
            (string) ($conf['apikey'] ?? '')
        );
        $checker = \aiprovider_ragflow\local\health\checker::instance();
        $out = [];
        foreach ($selected as $id) {
            // Keep every stored dataset selectable; label a stale one by its checker state (missing vs
            // unverified) instead of showing the bare id, so a save never drops it and the label is clear.
            $out[$id] = isset($all[$id])
                ? $all[$id]
                : \aiprovider_ragflow\local\health\checker::stale_option_label($checker->check_knowledge_base($id));
        }
        return $out;
    }
}
