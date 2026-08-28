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

namespace block_ragflowsearch;

use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Unit tests for the RAGflow search block class.
 *
 * @package    block_ragflowsearch
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[CoversClass(\block_ragflowsearch::class)]
final class block_ragflowsearch_test extends \advanced_testcase {
    /**
     * The block's placement/configuration contract: shown everywhere, single instance, per-instance config,
     * no global settings.
     *
     * @return void
     */
    public function test_block_contract(): void {
        global $CFG;
        require_once($CFG->dirroot . '/blocks/moodleblock.class.php');
        require_once($CFG->dirroot . '/blocks/ragflowsearch/block_ragflowsearch.php');
        $block = new \block_ragflowsearch();
        $this->assertSame(['all' => true], $block->applicable_formats());
        $this->assertFalse($block->instance_allow_multiple());
        $this->assertTrue($block->instance_allow_config());
        $this->assertFalse($block->has_config());
    }

    /**
     * instance_config_save() persists for a site admin but is a no-op for a non-admin (so the configured
     * knowledge base cannot be cleared by someone without the rights).
     *
     * @return void
     */
    public function test_config_save_requires_admin(): void {
        global $DB;
        $this->resetAfterTest();
        $ctx = \context_system::instance();
        $record = $this->getDataGenerator()->create_block('ragflowsearch', ['parentcontextid' => $ctx->id]);

        // Admin save persists.
        $this->setAdminUser();
        $block = block_instance('ragflowsearch', $DB->get_record('block_instances', ['id' => $record->id]));
        $block->instance_config_save((object) ['scope' => 'all']);
        $saved = unserialize(base64_decode($DB->get_field('block_instances', 'configdata', ['id' => $record->id])));
        $this->assertSame('all', $saved->scope);

        // Non-admin save is ignored (config unchanged).
        $this->setUser($this->getDataGenerator()->create_user());
        $block = block_instance('ragflowsearch', $DB->get_record('block_instances', ['id' => $record->id]));
        $block->instance_config_save((object) ['scope' => 'course']);
        $after = unserialize(base64_decode($DB->get_field('block_instances', 'configdata', ['id' => $record->id])));
        $this->assertSame('all', $after->scope, 'a non-admin must not be able to change the block config');
    }
}
