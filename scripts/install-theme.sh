#!/bin/bash

# Lade gemeinsame Funktionen
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"
load_env

# Prüfe ob Container laufen
require_running_containers

# Warte auf WordPress Container
wait_for_wordpress || exit 1

# GitHub Repository für das Theme
THEME_REPO="https://github.com/Stileffekt/stileffekt-stilpress.git"
SSH_REPO="git@github.com:Stileffekt/stileffekt-stilpress.git"

# Theme-Name basierend auf dem aktuellen Verzeichnisnamen
CURRENT_DIR=$(basename "$PWD")
THEME_NAME="stileffekt-${CURRENT_DIR}"
THEME_PATH="./data/htdocs/wp-content/themes/${THEME_NAME}"

# Prüfe ob Theme-Ordner bereits existiert
if [ -d "$THEME_PATH" ]; then
    # Bei --force Flag: überschreiben
    if [ "$1" = "--force" ]; then
        echo "Lösche bestehendes Theme..."
        rm -rf "$THEME_PATH"
    else
        echo "Theme bereits installiert: ${THEME_NAME}"
        exit 0
    fi
fi

echo ""
echo "Stileffekt Theme Installation"
echo "Theme-Name: ${THEME_NAME}"
echo ""

# Funktion zum Klonen des Themes
clone_theme() {
    echo ""
    echo "Wähle die Authentifizierungsmethode:"
    echo "1) SSH (benötigt konfigurierte SSH-Keys)"
    echo "2) HTTPS (nutzt gespeicherte Credentials oder Token)"
    read -p "Auswahl (1/2): " AUTH_METHOD
    echo ""

    if [ "$AUTH_METHOD" = "1" ]; then
        echo "Klone Theme via SSH..."
        git clone "$SSH_REPO" "$THEME_PATH"
    else
        echo "Klone Theme via HTTPS..."
        if git clone "$THEME_REPO" "$THEME_PATH" 2>/dev/null; then
            echo "Theme mit gespeicherten Credentials geklont"
        else
            echo "Clone fehlgeschlagen. Authentifizierung benötigt."
            echo ""
            echo "Für den Zugriff auf das private Repository wird ein GitHub Personal Access Token benötigt."
            echo "Du kannst einen Token hier erstellen: https://github.com/settings/tokens"
            echo ""
            read -sp "GitHub Personal Access Token: " GITHUB_TOKEN
            echo ""

            REPO_URL_WITH_TOKEN="https://${GITHUB_TOKEN}@github.com/Stileffekt/stileffekt-stilpress.git"
            git clone "$REPO_URL_WITH_TOKEN" "$THEME_PATH"
        fi
    fi

    return $?
}

# Theme klonen
if clone_theme; then
    # Entferne .git Ordner um Theme von Git zu trennen
    rm -rf "${THEME_PATH}/.git"
    echo ""
    echo "Theme erfolgreich installiert: ${THEME_NAME}"

    # Theme aktivieren
    echo "Aktiviere Theme..."
    docker compose exec -T wpcli wp theme activate "${THEME_NAME}"

    echo ""
    echo "Theme-Installation abgeschlossen!"
else
    echo ""
    echo "Fehler beim Klonen des Themes."
    echo "Bitte Token und Repository-Zugriff prüfen."
    exit 1
fi
