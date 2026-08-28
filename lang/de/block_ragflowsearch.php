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
 * German language strings for block_ragflowsearch.
 *
 * @package    block_ragflowsearch
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['adminonly'] = 'Nur Site-Administratoren können die Wissensbasis für diesen Block auswählen.';
$string['config_cliffratio'] = 'Relevanz-Klippe';
$string['config_cliffratio_help'] = 'Ein Treffer bleibt nur, solange sein Score innerhalb dieses Anteils (0–1) des besten Treffers liegt – schwache Ausläufer werden abgeschnitten. Niedriger = mehr mittelmäßige Treffer bleiben; 0 = aus (nur Mindest-Relevanz und Cap greifen). Standard: 0.6.';
$string['config_coursefield'] = 'Kurs-Metadatenfeld';
$string['config_coursefield_help'] = 'Das RAGflow-Dokument-Metadatenfeld, das die Moodle-Kurs-ID enthält. Wird nur verwendet, wenn der Bereich auf den aktuellen Kurs gesetzt ist. Standard: course_id.';
$string['config_datasets'] = 'Wissensbasis(en)';
$string['config_datasets_help'] = 'Die RAGflow-Wissensbasis(en), die dieser Block durchsucht. Ein oder mehrere Datasets auswählen. Erforderlich – der Block sucht erst, wenn mindestens eine ausgewählt ist.';
$string['config_datasets_none'] = 'Keine Wissensbasis ausgewählt';
$string['config_maxresults'] = 'Maximale Trefferzahl';
$string['config_maxresults_help'] = 'Maximale Anzahl angezeigter Text-Dokumente. Bilder/Medien bilden zusätzlich eine eigene kleine Gruppe. Standard: 5.';
$string['config_minsimilarity'] = 'Mindest-Relevanz';
$string['config_minsimilarity_help'] = 'Text-Treffer unter diesem Relevanz-Score (0–1) werden verworfen. Höher = weniger, strengere Treffer; niedriger = mehr, lockerer. Bilder/Medien behalten ihre eigene, niedrigere Schwelle und werden nicht ausgeblendet. Standard: 0.35.';
$string['config_rerankmodel'] = 'Rerank-Modell (optional)';
$string['config_rerankmodel_help'] = 'Optional. Wähle eines der in deinem RAGflow konfigurierten Rerank-Modelle. Wenn gesetzt, ordnet RAGflow die gefundenen Kandidaten mit einem Cross-Encoder neu, was die Präzision deutlich erhöht (weniger, dafür bessere Treffer). „Keines" wählen für einfaches Vektor-/Keyword-Ranking. Die Relevanzschwelle, die niedrigere Schwelle für Bilder/Medien und die Trefferbegrenzung nutzen sinnvolle Defaults und müssen nicht konfiguriert werden.';
$string['config_rerankmodel_none'] = 'Keines (kein Reranking)';
$string['config_rerankmodel_unavailable'] = 'Aktuell ist in RAGflow kein Rerank-Modell verfügbar. Konfiguriere in deiner RAGflow-Instanz ein Rerank-Modell, um Reranking zu aktivieren.';
$string['config_scope'] = 'Suchbereich';
$string['config_scope_help'] = 'Ob die gesamte Wissensbasis durchsucht wird oder nur die Dokumente des aktuellen Kurses (über das Kurs-Metadatenfeld). Auf Seiten ohne Kurs (z. B. Dashboard) wird die gesamte Wissensbasis durchsucht.';
$string['config_vectorweight'] = 'Semantik-Gewicht';
$string['config_vectorweight_help'] = 'Balanciert semantische (Bedeutungs-)Treffer gegenüber wörtlicher Schlagwort-Suche in der Hybrid-Suche (0-1). Höher = in Satzform gestellte Fragen matchen nach Bedeutung; niedriger = wörtliche Schlagwort-Suche dominiert. RAGflows eigener Default (0.3) ist schlagwortlastig und bewertet Satzfragen schlecht. Standard: 0.7.';
$string['nodatasets'] = 'Es sind keine RAGflow-Wissensbasen verfügbar. Prüfen Sie, ob der RAGflow-Provider aktiviert und konfiguriert ist.';
$string['notconfigured'] = 'Die RAGflow Dateisuche ist noch nicht konfiguriert. Ein Site-Administrator muss in den Einstellungen dieses Blocks eine Wissensbasis auswählen.';
$string['pluginname'] = 'RAGflow Dateisuche';
$string['privacy:metadata'] = 'Der RAGflow-Dateisuche-Block speichert keine personenbezogenen Daten. Suchanfragen werden vom RAGflow-Provider an den konfigurierten RAGflow-Dienst gesendet, um passende Dokumente zu finden.';
$string['ragflowsearch:addinstance'] = 'Neuen RAGflow-Dateisuche-Block hinzufügen';
$string['ragflowsearch:myaddinstance'] = 'Neuen RAGflow-Dateisuche-Block zum Dashboard hinzufügen';
$string['scope:all'] = 'Gesamte Wissensbasis';
$string['scope:course'] = 'Nur aktueller Kurs';
