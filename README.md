# RAGflow search (block_ragflowsearch) #

A Moodle **block** that searches a [RAGflow](https://ragflow.io/) knowledge base semantically and lists
the matching source documents — **retrieval only, no LLM** (so it is fast, cheap and shows real
documents without hallucination). It reuses the shared search engine of the **RAGflow AI provider**
(`aiprovider_ragflow`), so credentials and knowledge bases are configured once and shared across the
suite.

## Features ##

* A search box placeable on any page (course, Dashboard, front page).
* **Per-instance configuration (site admins only):**
    * **Knowledge base(s)** — one or multiple per block instance.
    * **Search scope** — the whole knowledge base or only the current course (matched via a document
      metadata field, default `course_id`, written by the
      [RAGflow Moodle Connector](https://docs.ragcon.ai/ragflow-moodle-connector/); on pages without a
      course the whole knowledge base is searched).
* **Secure downloads** — source files are served through the RAGflow AI provider's file proxy, so the
  RAGflow API key never reaches the browser.

## Requirements ##

* **Moodle 5.0–5.2.**
* The **RAGflow AI provider** (`aiprovider_ragflow`) installed and enabled — it supplies the shared
  search engine + credentials and lists the available knowledge bases. This block declares a dependency
  on it.
* **External service (RAGflow), version 0.25 or later:** a reachable [RAGflow](https://ragflow.io/)
  instance and a **RAGflow API key**, configured once in the AI provider. RAGflow can be **self-hosted
  or hosted by RAGcon**. Without a configured RAGflow tenant (and a knowledge base chosen per block) the
  block cannot search.

## Installation ##

1. Copy the plugin to `blocks/ragflowsearch` in the Moodle tree (**Moodle 5.1+**: `public/blocks/ragflowsearch`).
2. Complete the installation via *Site administration → Notifications* or `php admin/cli/upgrade.php`.
3. Add the **RAGflow search** block to a page (turn editing on → *Add a block*).
4. As a **site administrator**, open the block's gear → *Configure* and select the knowledge base(s)
   and scope. The block does not search until a knowledge base is chosen.

## Usage ##

Type a query into the block and press **Search**. The most relevant documents from the configured
knowledge base are listed with a score and a snippet; click a title to open the source document.

## Documentation ##

Full setup and usage documentation: <https://docs.ragcon.ai/moodle-ragflow/plugins/search/>

## Privacy and GDPR ##

* Implements the **Moodle Privacy API**: the block stores no personal data of its own.
* Search queries are sent to RAGflow through the **RAGflow AI provider** (`aiprovider_ragflow`), which
  owns the data-processing and GDPR handling — see that plugin's *Privacy* section. RAGflow can be
  **self-hosted or hosted by RAGcon**, so the data-processing location is under the operator's control.

## Issues & Contributing ##

* Issues and feature requests: <https://github.com/ragcon-ai/moodle-block_ragflowsearch/issues>

  Please include your **RAGflow version**, **Moodle version**, **plugin version** and the **exact steps
  to reproduce**.
* Pull requests are welcome. The plugin stays **GPLv3**; by contributing you agree your changes are
  licensed under the same terms.

## Support ##

Professional support and web hosting for RAGflow + Moodle are available from **RAGcon GmbH** —
<https://www.ragcon.ai/en> (www.ragcon.ai).

## Community ##

* Moodle — <https://moodle.org>
* RAGflow — <https://ragflow.io>

## Changelog ##

### 0.7.0 ###

* **First public release (beta).** A Moodle block for semantic file search over one or more RAGflow
  knowledge bases: retrieval only (no LLM), per-instance knowledge-base and scope selection for site
  admins, results ranked by match score, and secure source downloads through the provider proxy.

## Acknowledgements ##

This plugin integrates two independent software projects:

* **Moodle** — software by Moodle Pty Ltd, released under the GNU GPL v3 or later
  (<https://github.com/moodle/moodle>). *The word Moodle and associated Moodle logos are trademarks or
  registered trademarks of Moodle Pty Ltd or its related affiliates.*
* **RAGflow** — open-source software by InfiniFlow Inc., released under the Apache License 2.0
  (<https://ragflow.io> · <https://github.com/infiniflow/ragflow>).

This plugin is an independent integration and is not affiliated with or endorsed by Moodle Pty Ltd or
InfiniFlow Inc.

## Development ##

This plugin is part of the Moodle RAGflow suite, developed with the help of a range of AI tools under
the professional supervision of the RAGcon GmbH team — pairing fast, AI-assisted development with human
review, automated testing and security checks before every release.

## License ##

Copyright 2026 RAGcon GmbH <info@ragcon.ai>

This program is free software: you can redistribute it and/or modify it under the terms of the GNU
General Public License as published by the Free Software Foundation, either version 3 of the License,
or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.

The full licence text is in `LICENSE`, or at <https://www.gnu.org/licenses/gpl-3.0.html>.
