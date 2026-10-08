# Projektkontext

Dieses Projekt ist eine lokale WordPress-Installation. Das relevante Theme liegt typischerweise unter:

`data/htdocs/wp-content/themes/stileffekt-*`

Das Theme basiert stark auf Advanced Custom Fields (ACF). Inhaltselemente sind als eigene Gutenberg/ACF-Blöcke im Theme umgesetzt.

## Theme-Struktur

- Aktive Blöcke werden in `includes/includes.php` über `$block_config` gesteuert.
- Die Block-Registrierung und erlaubten Editor-Blöcke laufen über `includes/blocks/blocks.php`.
- Die zentrale Hilfsklasse liegt in `includes/blocks/blocks-helper.php`.
- Inhaltselemente liegen unter `includes/blocks/b-*`.
- Widgets liegen unter `includes/blocks/w-*`.
- Globale SCSS-Komponenten liegen unter `assets/styles/components`.
- Blockeigene Styles liegen direkt im jeweiligen Block-Ordner als `style.scss` und kompiliertes `style.css`.

## Block-Muster

Die Blöcke folgen einem wiederkehrenden Aufbau:

- `block.json` registriert den Block.
- `fields.json` enthält die ACF-Feldgruppe.
- `block.php` liest und normalisiert Daten.
- `view.php` rendert das Markup.
- `style.scss` enthält blockbezogene Layout- und Variantenstyles.
- Optional gibt es `script.js` für Interaktion.

Die Klasse `Stilpress_Block_Helper` spiegelt namespaced ACF-Felder auf semantische Feldnamen. Ein Feld wie `b-text__headline` kann im Block also als `headline` abgefragt werden. Bei Repeatern werden auch Item-Präfixe vereinfacht, z. B. `b-content-boxes__item_headline` zu `headline` innerhalb des Items.

## Arbeitsweise

- Vor Änderungen zuerst die betroffenen Blockdateien lesen.
- Bestehende Muster im jeweiligen Block übernehmen, statt neue Strukturen einzuführen.
- Logik bevorzugt in `block.php` oder einer blockeigenen Helper-Erweiterung halten; `view.php` möglichst schlank lassen.
- Globale Komponenten nur ändern, wenn mehrere Blöcke davon profitieren oder ein globales Verhalten betroffen ist.
- `fields.json`-Namen müssen zum Blocknamen passen, damit die semantischen Aliase funktionieren.
- Vorhandene Änderungen im Worktree nicht zurücksetzen oder überschreiben.

## Aktive Blöcke

Die aktuell aktiven Content-Blöcke stehen in `includes/includes.php`.

Nicht alle Blöcke müssen vor einer Änderung gelesen werden. Da das System repetitiv ist, reichen meist der betroffene Block plus ein bis zwei ähnliche aktive Blöcke als Referenz.
