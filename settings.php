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
 * Global settings for block_ragflowsearch. (The knowledge base and result-quality knobs are per block
 * instance; this page holds only the site-wide logging toggle.)
 *
 * @package    block_ragflowsearch
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // Write a slim usage/error entry to the Moodle standard log per request (opt-in; see help).
    $settings->add(new admin_setting_configcheckbox(
        'block_ragflowsearch/logtomoodle',
        get_string('logtomoodle', 'aiprovider_ragflow'),
        get_string('logtomoodle_desc', 'aiprovider_ragflow'),
        0
    ));
}
