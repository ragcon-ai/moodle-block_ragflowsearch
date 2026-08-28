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
 * RAGflow semantic-search block.
 *
 * A thin trigger: it renders the shared search widget hosted by the RAGflow provider
 * (`\aiprovider_ragflow\output\search`), which searches the context-appropriate knowledge base
 * (course vs. site) via RAGflow retrieval – no LLM.
 *
 * @package    block_ragflowsearch
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_ragflowsearch extends block_base {
    /**
     * Set the block title.
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_ragflowsearch');
    }

    /**
     * Render the search widget (shared engine in the provider).
     *
     * @return \stdClass
     */
    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';

        if (!isloggedin() || isguestuser()) {
            return $this->content;
        }
        // The shared search engine lives in the RAGflow provider.
        if (!class_exists('\aiprovider_ragflow\output\search')) {
            return $this->content;
        }

        // The knowledge base to search is chosen per block instance (by a site admin). Without it the
        // block cannot search; show a short hint to whoever is allowed to configure it, nothing otherwise.
        $datasets = (array) ($this->config->datasets ?? []);
        if (empty(array_filter($datasets))) {
            if (has_capability('block/ragflowsearch:addinstance', $this->context)) {
                $this->content->text = \html_writer::div(
                    get_string('notconfigured', 'block_ragflowsearch'),
                    'text-muted small'
                );
            }
            return $this->content;
        }

        $this->content->text = \aiprovider_ragflow\output\search::render_search([
            'contextid' => (int) $this->page->context->id,
            'blockinstanceid' => (int) $this->instance->id,
        ]);
        return $this->content;
    }

    /**
     * Allow the block on all page types.
     *
     * @return array
     */
    public function applicable_formats() {
        return ['all' => true];
    }

    /**
     * Only one instance per page.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * This block has a per-instance configuration form (knowledge base + scope).
     *
     * @return bool
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * Persist the instance configuration – restricted to site administrators (the form shows no fields
     * to anyone else, and this guard makes a non-admin save a no-op so the KB choice cannot be cleared).
     *
     * @param stdClass $data
     * @param bool $nolongerused
     * @return void
     */
    public function instance_config_save($data, $nolongerused = false) {
        if (!is_siteadmin()) {
            return;
        }
        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * No global configuration.
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }
}
