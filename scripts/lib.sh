#!/bin/bash

# Gemeinsame Funktionen für alle Scripts

# Ermittle Root-Verzeichnis (eine Ebene über scripts/)
LIB_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$LIB_DIR/.." && pwd)"

# Wechsle ins Projekt-Root (für docker compose)
cd "$PROJECT_ROOT"

# Lade .env wenn vorhanden
load_env() {
    if [ -f "$PROJECT_ROOT/.env" ]; then
        source "$PROJECT_ROOT/.env"
    else
        echo "Fehler: .env nicht gefunden in $PROJECT_ROOT"
        exit 1
    fi
}

# Prüfe ob WordPress installiert ist
is_wordpress_installed() {
    # Wenn Container laufen, nutze WP-CLI
    if [ -n "$(docker compose ps -q 2>/dev/null)" ]; then
        docker compose exec -T wpcli wp core is-installed 2>/dev/null
        return $?
    fi
    # Sonst prüfe Dateisystem
    [ -f "data/htdocs/wp-includes/version.php" ]
}

# Warte auf WordPress Container
wait_for_wordpress() {
    local timeout=${1:-60}
    local counter=0
    echo "Warte auf WordPress Container..."
    until docker compose exec -T wp test -f /var/www/html/wp-load.php 2>/dev/null; do
        sleep 2
        counter=$((counter + 2))
        if [ $counter -ge $timeout ]; then
            echo "Fehler: WordPress Container nicht bereit nach ${timeout}s"
            return 1
        fi
    done
    echo "WordPress Container ist bereit."
    return 0
}

# Prüfe ob Container laufen
require_running_containers() {
    if [ -z "$(docker compose ps -q 2>/dev/null)" ]; then
        echo "Fehler: Container laufen nicht. Starte sie mit ./dev.sh start"
        exit 1
    fi
}

# Prüfe ob Container NICHT laufen
require_stopped_containers() {
    if [ -n "$(docker compose ps -q 2>/dev/null)" ]; then
        echo "Fehler: Container laufen bereits. Stoppe sie mit ./dev.sh stop"
        exit 1
    fi
}

# Verzeichnis löschen (mit sudo-Fallback)
remove_dir() {
    local dir=$1
    [ ! -d "$dir" ] && return 0

    rm -rf "$dir" 2>/dev/null
    if [ -d "$dir" ]; then
        sudo rm -rf "$dir"
    fi

    if [ -d "$dir" ]; then
        echo "FEHLER: Konnte $dir nicht löschen"
        return 1
    fi
    echo "  $dir gelöscht"
    return 0
}

# Browser-Sync starten
start_browser_sync() {
    if ! command -v browser-sync &> /dev/null; then
        echo "Browser-sync nicht installiert."
        echo "Installieren mit: npm install -g browser-sync"
        return 1
    fi

    pkill -f "browser-sync" 2>/dev/null || true

    local port=${BROWSER_SYNC_PORT:-3012}
    echo "Starte Browser-Sync auf http://localhost:${port}"
    browser-sync start \
        --proxy "localhost:${WP_PORT}" \
        --port $port \
        --files "data/htdocs/wp-content/themes/**/*.css" \
        --files "data/htdocs/wp-content/themes/**/*.php" \
        --no-notify \
        > /dev/null 2>&1 &
}

# Port-Check Funktion
check_port() {
    local port=$1
    local name=$2

    # Prüfe zuerst ob ein Docker-Container den Port belegt
    DOCKER_CONTAINER=$(docker ps --filter "publish=$port" --format "{{.Names}}" 2>/dev/null | head -1)
    if [ -n "$DOCKER_CONTAINER" ]; then
        PROJECT_NAME=$(echo "$DOCKER_CONTAINER" | sed 's/-[^-]*-[0-9]*$//')
        echo "Fehler: Port $port ($name) ist bereits belegt durch Projekt: $PROJECT_NAME"
        return 1
    fi

    # Prüfe ob ein anderer Prozess den Port belegt
    if ss -tlnp 2>/dev/null | grep -q ":$port "; then
        echo "Fehler: Port $port ($name) ist bereits belegt durch:"
        ss -tlnp 2>/dev/null | grep ":$port "
        return 1
    fi

    return 0
}
