# Status: Block-JavaScript fuer WordPress 7.1

Stand: 5. Oktober 2026

## Ergebnis

Die JavaScript-Blöcke funktionieren jetzt mit dem iframe-basierten Blockeditor von WordPress 7.1 und mit wiederholten ACF-Preview-Refreshes. Die Blockskripte werden im Frontend weiterhin nur geladen, wenn der jeweilige Block auf der Seite vorhanden ist.

Es wurde kein Commit erstellt.

## Gemeinsamer Lifecycle

- `assets/scripts/blocks.js` stellt die globale API `window.stilpressBlocks` bereit.
- Pro Dokument läuft genau ein `MutationObserver`.
- Die Runtime initialisiert vorhandene und später eingefügte Blockelemente.
- Eine `Map` verhindert doppelte Initialisierungen.
- Beim Entfernen oder Ersetzen eines Blocks wird dessen Cleanup ausgeführt.
- Der Observer arbeitet immer nur im aktuellen Dokument. Dadurch bleibt die Ausführung außerhalb des Editor-iframes wirkungslos.
- `registerSplide()` bündelt Mount und `destroy(true)` für alle Slider.
- `registerScrollArrow()` bündelt die gemeinsame Hero- und Page-Title-Funktion.

## Asset-Registrierung

- Die gemeinsamen Bibliotheken werden in `functions.php` auf `init` mit Priorität 5 registriert. Dadurch sind die Handles vor der Blockregistrierung im Frontend und Editor verfügbar.
- Die globalen Frontend-Assets werden weiterhin ausschließlich über `wp_enqueue_scripts` enqueued.
- Alle funktionalen Blockskripte verwenden in `block.json` jetzt `script` statt `viewScript`.
- Neben jedem lokalen Blockscript liegt eine `.asset.php` mit der echten Abhängigkeitskette.
- Die Theme-Version wurde für Cache-Busting in `functions.php` und `style.css` von `1.1.0` auf `1.1.1` erhöht.

## Migrierte Blöcke

- `b-countdown`: Intervall wird beim Entfernen und nach Ablauf beendet.
- `b-counter`: GSAP-Tweens und ScrollTriggers werden beim Entfernen beendet.
- `b-downloads-accordion`: Eventlistener werden über `AbortController` entfernt.
- `b-employees-slider`: gemeinsame Splide-Initialisierung und Cleanup.
- `b-faqs`: Eventlistener werden sauber entfernt.
- `b-hero`: gemeinsame Scroll-Pfeil-Initialisierung.
- `b-icon-list`: Listener, Resize-Timeouts und Transition-Timeouts werden bereinigt.
- `b-image-slider`: gemeinsame Splide-Initialisierung und Cleanup.
- `b-logo-slider`: gemeinsame Splide-Initialisierung inklusive AutoScroll-Erweiterung und Cleanup.
- `b-page-title`: Pfeil-Markup und dieselbe Scroll-Funktion wie beim Hero ergänzt.
- `b-products`: Tabs sind blocklokal; Listener werden entfernt.
- `b-quotes-slider`: gemeinsame Splide-Initialisierung und Cleanup.
- `b-quotes`: der derzeit inaktive Vorlagenblock wurde ebenfalls migriert, aber nicht aktiviert.
- `b-references`: Filter sind blocklokal und unterstützen mehrere Blockinstanzen.

## Entfernte Altlasten

- Choices.js wurde vollständig entfernt.
- Die Choices-Registrierung und die Blockabhängigkeit wurden entfernt.
- `assets/scripts/_lib/choices/choices.min.js` wurde gelöscht.
- `b-references` verwendet vorerst native Mehrfachauswahlen und ein eigenes `change`-Filtering.
- Die ungenutzte und fehlerhafte JS-Datei von `b-image-gallery` wurde gelöscht.
- Der leere Script-Eintrag von `b-image-gallery` wurde entfernt.
- Das vollständig auskommentierte Script von `b-employees` wurde gelöscht.
- Die leeren Script-Einträge von `b-text` und `b-video` wurden entfernt.

## Markup und Barrierefreiheit

- Die Hero- und Page-Title-Pfeile sind echte Buttons mit zugänglichem Namen.
- Die Pfeile bleiben nach der ersten Nutzung funktionsfähig.
- Die Pfeilanimation wird bei `prefers-reduced-motion: reduce` deaktiviert.
- Die Reference-Filter besitzen eindeutige, blockbezogene IDs und zugeordnete Labels.
- Die Meldung bei leeren Reference-Ergebnissen verwendet `role="status"`.

## Verifikation

- Alle geänderten JavaScript-Dateien bestehen `node --check`.
- Alle `block.json`-Dateien sind valides JSON.
- `functions.php`, die geänderten Views und alle `.asset.php`-Dateien bestehen `php -l`.
- `git diff --check` meldet keine Whitespace-Fehler.
- WordPress registriert alle 14 Script-Blöcke mit den erwarteten Handles und Dependencies.
- Die No-op-Blöcke `b-employees`, `b-image-gallery`, `b-text` und `b-video` besitzen keine Script-Handles mehr.
- Ein echter Browser-Test im Frontend bestätigte genau eine Initialisierung und genau ein Cleanup eines dynamisch eingefügten Elements.
- Ein echter ACF-AJAX-Refresh im WordPress-7.1-Editor bestätigte den erwarteten Lifecycle: zwei Initialisierungen und ein Cleanup.
- Ein synthetischer Image-Slider wurde im Editor erfolgreich durch Splide gemountet.
- Zwei synthetische Reference-Blöcke filterten unabhängig voneinander.
- Hero-Scroll wurde im Frontend ausgeführt.
- Während der Browser-Prüfungen gab es keine JavaScript- oder Konsolenfehler.
- Im Frontend wurden nur die Runtime und das Script des tatsächlich vorhandenen Hero-Blocks geladen. Beide wurden im Footer ausgegeben.

## Hinweise fuer morgen

- Der Worktree enthielt schon vor dieser Aufgabe viele nicht zugehörige Änderungen. Diese wurden nicht zurückgesetzt oder überschrieben.
- Insbesondere die bereits vorhandenen Hero-Anpassungen wurden als aktueller Stand übernommen und um den neuen Lifecycle ergänzt.
- Die kompilierten Dateien `includes/blocks/b-hero/style.css` und `includes/blocks/b-page-title/style.css` wurden lokal aktualisiert. Unterordner-CSS ist durch die aktuelle `.gitignore` ausgeblendet und erscheint deshalb nicht in `git status`.
- Die Sass-Kompilierung war erfolgreich. Sie meldet bestehende Deprecation-Warnungen in `assets/styles/mixins/_breakpoints.scss` für die alte `if()`- und `map-get()`-Syntax. Diese Warnungen gehören nicht zu dieser Aufgabe.
- Die neuen Dateien `assets/scripts/blocks.js` und die 14 `.asset.php`-Dateien sind noch unversioniert und müssen bei einem späteren Commit aufgenommen werden.
- `status.md` ist ebenfalls neu und unversioniert.

## Relevante neue Dateien

- `assets/scripts/blocks.js`
- `includes/blocks/b-countdown/view.asset.php`
- `includes/blocks/b-counter/script.asset.php`
- `includes/blocks/b-downloads-accordion/script.asset.php`
- `includes/blocks/b-employees-slider/script.asset.php`
- `includes/blocks/b-faqs/script.asset.php`
- `includes/blocks/b-hero/script.asset.php`
- `includes/blocks/b-icon-list/script.asset.php`
- `includes/blocks/b-image-slider/script.asset.php`
- `includes/blocks/b-logo-slider/script.asset.php`
- `includes/blocks/b-page-title/script.asset.php`
- `includes/blocks/b-products/script.asset.php`
- `includes/blocks/b-quotes/script.asset.php`
- `includes/blocks/b-quotes-slider/script.asset.php`
- `includes/blocks/b-references/script.asset.php`

## Letzter Teststand

Der abschließende Browser-Test war erfolgreich:

```text
Frontend lifecycle: init 1, cleanup 1
Editor ACF refresh: init 2, cleanup 1
Splide mounted: true
Reference instances independent: true
Console errors: none
```
