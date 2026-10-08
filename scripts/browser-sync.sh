#!/bin/bash

# Lade gemeinsame Funktionen
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"
load_env

require_running_containers
start_browser_sync
