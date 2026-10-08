#!/bin/bash

# Lade gemeinsame Funktionen
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"
load_env

# Prüfe ob Container laufen
require_running_containers

# Warte auf WordPress Container
wait_for_wordpress || exit 1

# Prüfe ob WordPress bereits installiert ist
if is_wordpress_installed; then
    echo "WordPress ist bereits installiert."
    exit 0
fi

echo "Installiere WordPress..."

# WordPress Installation
docker compose exec -T wpcli wp core install \
    --url="http://localhost:${WP_PORT}" \
    --title="${WP_TITLE}" \
    --admin_user="${WP_ADMIN_USER}" \
    --admin_password="${WP_ADMIN_PASSWORD}" \
    --admin_email="${WP_ADMIN_EMAIL}" \
    --skip-email

# Suchmaschinen-Sichtbarkeit setzen
docker compose exec -T wpcli wp option update blog_public "${WP_PUBLIC}"

# Permalink-Struktur auf "Post name" setzen
docker compose exec -T wpcli wp rewrite structure '/%postname%/' --hard

# Upload-Organisation nach Monat/Jahr deaktivieren
docker compose exec -T wpcli wp option update uploads_use_yearmonth_folders 0

# Zeitformat setzen
docker compose exec -T wpcli wp option update time_format 'H:i'

# Datumsformat setzen
docker compose exec -T wpcli wp option update date_format 'd.m.Y'

# Zeitzone auf Berlin setzen
docker compose exec -T wpcli wp option update timezone_string 'Europe/Berlin'

# Avatare deaktivieren
docker compose exec -T wpcli wp option update show_avatars 0

# Standard-Inhalte löschen
echo "Lösche Standard-Inhalte..."
docker compose exec -T wpcli wp post delete 1 --force 2>/dev/null || true
docker compose exec -T wpcli wp post delete 2 --force 2>/dev/null || true
docker compose exec -T wpcli wp comment delete 1 --force 2>/dev/null || true

# Standard-Plugins entfernen
echo "Entferne Standard-Plugins..."
docker compose exec -T wpcli wp plugin delete akismet 2>/dev/null || true
docker compose exec -T wpcli wp plugin delete hello 2>/dev/null || true

# Standard-Themes entfernen (alle inaktiven "twenty*"-Themes)
echo "Entferne Standard-Themes..."
INACTIVE_THEMES=$(docker compose exec -T wpcli wp theme list --status=inactive --field=name --format=csv 2>/dev/null | tr ',' '\n' | grep '^twenty')
if [ -n "$INACTIVE_THEMES" ]; then
    echo "$INACTIVE_THEMES" | xargs -I{} docker compose exec -T wpcli wp theme delete {} --force 2>/dev/null || true
fi

echo ""
echo "WordPress erfolgreich installiert!"
echo ""
echo "Login-Daten:"
echo "  URL:      http://localhost:${WP_PORT}/wp-admin"
echo "  User:     ${WP_ADMIN_USER}"
echo "  Password: ${WP_ADMIN_PASSWORD}"
