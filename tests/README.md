# Tests – block_ragflowsearch

**Plugin version:** `2026082311` (release `0.6.9`) — update this line whenever the tests or the plugin
version change.

PHPUnit tests for this plugin. They run automatically in the bundled **moodle-plugin-ci** GitHub Actions
workflow; to run them locally, use `vendor/bin/phpunit` from a configured Moodle root (see the
[Moodle PHPUnit docs](https://moodledev.io/general/development/tools/phpunit)).

This file records **what the tests verify**, in **execution order** (PHPUnit runs the methods top-to-bottom
as defined in each class). Keep it in sync when tests are added, reordered or changed.

This block is deliberately thin: it renders the shared search widget and delegates the retrieval to the
RAGflow provider (`aiprovider_ragflow`), where the search logic and its tests live.

## Coverage

### `block_ragflowsearch_test.php` — search block (`\block_ragflowsearch`)

| # | Test | Verifies |
|---|---|---|
| 1 | `test_block_contract` | placement/config contract: shown in all formats, single instance, per-instance config, no global settings. |
| 2 | `test_config_save_requires_admin` | `instance_config_save()` persists for a site admin but is a **no-op for a non-admin**, so the configured knowledge base cannot be cleared without rights. |

### `behat/search_block.feature` — acceptance (`@block_ragflowsearch @javascript`)

Run with **moodle-plugin-ci** (the bundled CI runs Behat automatically) or `vendor/bin/behat` from a
configured Moodle (see the [Moodle Behat docs](https://moodledev.io/general/development/tools/behat)).

| # | Scenario | Verifies |
|---|---|---|
| 1 | The block shows a not-configured hint until a knowledge base is chosen | A site admin can add the **RAGflow search** block and is told to configure a knowledge base (no RAGflow call needed for this path). |

## Deliberately not covered here (needs integration / a running RAGflow)

- The actual retrieval / result rendering and the config autocomplete live in the provider
  (`aiprovider_ragflow`) and are covered there.
- Search scenarios that return real results need a reachable RAGflow tenant, so they are not automated here.
