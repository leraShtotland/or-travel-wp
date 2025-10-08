#!/usr/bin/env bash
set -euo pipefail

usage() {
    cat <<'USAGE'
Create a deployable ZIP archive of the or-travel-child theme.

Usage: package-theme.sh [options]

Options:
  -o, --output-dir DIR   Directory to place the generated ZIP (default: dist)
  -n, --name NAME        Override the output filename (without extension)
      --dry-run          Print the resolved filename without creating it
  -h, --help             Show this help message
USAGE
}

SCRIPT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
REPO_ROOT=$(cd "$SCRIPT_DIR/.." && pwd)
THEME_PATH="wp-content/themes/or-travel-child"
FULL_THEME_PATH="$REPO_ROOT/$THEME_PATH"

if [[ ! -d "$FULL_THEME_PATH" ]]; then
    echo "Theme directory not found at $FULL_THEME_PATH" >&2
    exit 1
fi

OUTPUT_DIR="$REPO_ROOT/dist"
CUSTOM_NAME=""
DRY_RUN=0

while [[ $# -gt 0 ]]; do
    case "$1" in
        -o|--output-dir)
            [[ $# -lt 2 ]] && { echo "Missing value for $1" >&2; exit 1; }
            OUTPUT_DIR="$2"
            shift 2
            ;;
        -n|--name)
            [[ $# -lt 2 ]] && { echo "Missing value for $1" >&2; exit 1; }
            CUSTOM_NAME="$2"
            shift 2
            ;;
        --dry-run)
            DRY_RUN=1
            shift
            ;;
        -h|--help)
            usage
            exit 0
            ;;
        *)
            echo "Unknown argument: $1" >&2
            usage >&2
            exit 1
            ;;
    esac
done

# Resolve the output directory to an absolute path
if [[ ! "$OUTPUT_DIR" = /* ]]; then
    OUTPUT_DIR="$REPO_ROOT/$OUTPUT_DIR"
fi

if [[ ! -d "$OUTPUT_DIR" ]]; then
    mkdir -p "$OUTPUT_DIR"
fi

OUTPUT_DIR=$(cd "$OUTPUT_DIR" && pwd)

if [[ -z "$CUSTOM_NAME" ]]; then
    GIT_COMMIT=$(cd "$REPO_ROOT" && git rev-parse --short HEAD)
    TIMESTAMP=$(date +%Y%m%d%H%M%S)
    BASE_NAME="or-travel-child-$TIMESTAMP-$GIT_COMMIT"
else
    BASE_NAME="$CUSTOM_NAME"
fi

OUTPUT_FILE="$OUTPUT_DIR/$BASE_NAME.zip"

if [[ $DRY_RUN -eq 1 ]]; then
    echo "[dry-run] Would create $OUTPUT_FILE"
    exit 0
fi

if ! command -v git >/dev/null 2>&1; then
    echo "git is required to package the theme" >&2
    exit 1
fi

( cd "$REPO_ROOT" && git archive --format=zip --output="$OUTPUT_FILE" HEAD:"$THEME_PATH" )

echo "Created theme package: $OUTPUT_FILE"
