# Stileffekt WordPress Development Environment

## Verwendung

```bash
./dev start    # Startet/Installiert alles (Container, WordPress, Theme, Browser-Sync, WP-CLI)
./dev stop     # Stoppt alles Container
./dev reset    # Löscht alle Daten und setzt zurück (htdocs und mysql)
./dev logs     # Container-Logs anzeigen
./dev status   # Container-Status anzeigen
```

## Projektdaten

| Pfad | Inhalt |
|------|--------|
| `data/htdocs/` | WordPress-Dateien |
| `data/htdocs/wp-content/themes/stileffekt-*` | Stipress Default Theme bekommt Projektnamen |
| `data/mysql/` | Datenbank |
| `.env` | Konfiguration (Ports, Passwörter) |

## URLs

| Service | URL |
|---------|-----|
| WordPress | http://localhost:8080 |
| PHPMyAdmin | http://localhost:8081 |
| Browser-Sync | http://localhost:3012 |

## Login

- **User:** `admin`
- **Passwort:** `admin`

Änderbar in `.env` (`WP_ADMIN_USER`, `WP_ADMIN_PASSWORD`).

## Neues Projekt aus Template

```bash
git clone git@github.com:Stileffekt/env-docker.git mein-projekt
cd mein-projekt
./dev start    # Erkennt Template automatisch und initialisiert Git neu
```

`./dev start` erkennt dabei, dass der Remote auf das Template zeigt, entfernt das Template-`.git` und erstellt ein frisches Repository für das neue Projekt.

### Theme-Tracking aktivieren

Das `.gitignore` ignoriert `data/htdocs/` standardmäßig vollständig, damit das Template-Repo sauber bleibt. In einem Projekt-Repo muss das Theme getrackt werden. Dazu die entsprechenden Zeilen in `.gitignore` einkommentieren:

```bash
# Vor der ersten Arbeit am Theme – in .gitignore die Theme-Zeilen einkommentieren:
# !data/htdocs/wp-content/
# data/htdocs/wp-content/*
# ... (alle Theme-Tracking-Zeilen)
```

Die Zeilen befinden sich im Abschnitt `# Theme-Tracking für Projekt-Repos` in der `.gitignore`.

## Diese Vorlage weiterentwickeln

Dieser Schritt ist nur nötig, wenn direkt in diesem Repo gearbeitet werden soll. Dieses Repo ist für Developer gedacht, die an einem neuen WordPress Projekt arbeiten. Nach dem Klonen des Template-Repos wird der .git Ordner daher gelöscht und ein neuer initialisiert. Die Datei .dev-instance schützt vor dem löschen und muss einmalig lokale erstellt werden. Sie verhindert, dass `./dev start` den `.git` Ordner entfernt.

```bash
git clone git@github.com:Stileffekt/env-docker.git
cd env-docker
touch .dev-instance   # einmalig – wird nicht committed
./dev start
```

Ohne `.dev-instance` würde `./dev start` das Repository wie einen normalen Projekt-Klon behandeln und das `.git` ersetzen.

## Xdebug

- **Port:** 9003
- **Path-Mapping:** `/var/www/html` → `data/htdocs`
