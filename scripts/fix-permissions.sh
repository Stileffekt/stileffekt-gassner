#!/bin/bash

# Wechsle ins Projekt-Root-Verzeichnis
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."

CURRENT_USER=$(whoami)
USER_ID=$(id -u)
GROUP_ID=$(id -g)

echo "Setze Permissions für data/htdocs..."
echo "User: $CURRENT_USER (UID: $USER_ID, GID: $GROUP_ID)"

mkdir -p data/htdocs

if [ -w data/htdocs ]; then
    chown -R $USER_ID:$GROUP_ID data/htdocs 2>/dev/null || sudo chown -R $USER_ID:$GROUP_ID data/htdocs
else
    sudo chown -R $USER_ID:$GROUP_ID data/htdocs
fi

find data/htdocs -type d -exec chmod 775 {} \; 2>/dev/null || sudo find data/htdocs -type d -exec chmod 775 {} \;
find data/htdocs -type f -exec chmod 664 {} \; 2>/dev/null || sudo find data/htdocs -type f -exec chmod 664 {} \;

# Scripts ausführbar machen
chmod +x dev 2>/dev/null || true
chmod +x scripts/*.sh 2>/dev/null || true

echo "Fertig!"
