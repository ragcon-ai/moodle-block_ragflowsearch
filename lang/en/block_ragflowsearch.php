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
 * English language strings for block_ragflowsearch.
 *
 * @package    block_ragflowsearch
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['adminonly'] = 'Only site administrators can choose the knowledge base for this block.';
$string['config_cliffratio'] = 'Relevance cliff';
$string['config_cliffratio_help'] = 'Keep a result only while its score stays within this fraction (0–1) of the best hit, so weak tail matches are cut. Lower = keep more mid-ranked results; 0 = off (only the minimum relevance and the cap apply). Default: 0.6.';
$string['config_coursefield'] = 'Course metadata field';
$string['config_coursefield_help'] = 'The RAGflow document metadata field that holds the Moodle course id. Only used when the scope is set to the current course. Default: course_id.';
$string['config_datasets'] = 'Knowledge base(s)';
$string['config_datasets_help'] = 'The RAGflow knowledge base(s) this block searches. Select one or more datasets. Required — the block does not search until at least one is chosen.';
$string['config_datasets_none'] = 'No knowledge base selected';
$string['config_maxresults'] = 'Maximum results';
$string['config_maxresults_help'] = 'The maximum number of text documents shown. Images/media form their own small group in addition. Default: 5.';
$string['config_minsimilarity'] = 'Minimum relevance';
$string['config_minsimilarity_help'] = 'Text results below this relevance score (0–1) are dropped. Higher = fewer, stricter matches; lower = more, looser. Images/media keep their own, lower floor so they are not hidden. Default: 0.35.';
$string['config_rerankmodel'] = 'Rerank model (optional)';
$string['config_rerankmodel_help'] = 'Optional. Choose one of the rerank models configured in your RAGflow. When set, RAGflow reorders the retrieved candidates with a cross-encoder, which markedly improves precision (fewer, better matches). Choose "None" for plain vector/keyword ranking. The relevance floor, the lower floor for images/media and the result cap use sensible defaults and need no configuration.';
$string['config_rerankmodel_none'] = 'None (no reranking)';
$string['config_rerankmodel_unavailable'] = 'No rerank model is currently available in RAGflow. Configure a rerank model in your RAGflow instance to enable reranking.';
$string['config_scope'] = 'Search scope';
$string['config_scope_help'] = 'Whether to search the whole knowledge base, or only the documents of the current course (matched via the course metadata field). On pages without a course (e.g. the Dashboard) the whole knowledge base is searched.';
$string['config_vectorweight'] = 'Semantic weight';
$string['config_vectorweight_help'] = 'Balances semantic (meaning) matching vs. literal keyword matching in the hybrid search (0-1). Higher = questions asked in full-sentence form match by meaning; lower = literal keyword matching dominates. RAGflow\'s own default (0.3) is keyword-heavy and scores sentence questions poorly. Default: 0.7.';
$string['nodatasets'] = 'No RAGflow knowledge bases are available. Check that the RAGflow provider is enabled and configured.';
$string['notconfigured'] = 'RAGflow file search is not configured yet. A site administrator must choose a knowledge base in this block\'s settings.';
$string['pluginname'] = 'RAGflow file search';
$string['privacy:metadata'] = 'The RAGflow file search block does not store any personal data. Search queries are sent to the configured RAGflow service by the RAGflow provider to retrieve matching documents.';
$string['ragflowsearch:addinstance'] = 'Add a new RAGflow file search block';
$string['ragflowsearch:myaddinstance'] = 'Add a new RAGflow file search block to the Dashboard';
$string['scope:all'] = 'Whole knowledge base';
$string['scope:course'] = 'Current course only';
