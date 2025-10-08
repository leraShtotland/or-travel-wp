#!/usr/bin/env bash
set -euo pipefail

usage() {
    cat <<'USAGE'
Synchronise the repository wp-content directory with a Local by Flywheel site.

Usage: sync-local.sh [options]

Options:
  -s, --site-name NAME       Name of the Local site (defaults to $LOCAL_SITE_NAME or "or-travel").
  -d, --local-sites-dir DIR  Root directory that contains Local sites (defaults to "$HOME/Local Sites").
      --push                 Copy from the repository into Local (default).
      --pull                 Copy from Local into the repository.
      --copy                 Force copy mode using rsync (default strategy).
      --symlink              Replace Local's wp-content with a symlink to the repo (macOS/Linux only).
      --dry-run              Show what would change without performing modifications.
      --no-delete            Avoid deleting files that are missing from the source.
  -h, --help                 Show this help message.
USAGE
}

SCRIPT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
REPO_ROOT=$(cd "$SCRIPT_DIR/.." && pwd)
REPO_WP_CONTENT="$REPO_ROOT/wp-content"

if [[ ! -d "$REPO_WP_CONTENT" ]]; then
    echo "wp-content directory not found at $REPO_WP_CONTENT" >&2
    exit 1
fi

SITE_NAME=${LOCAL_SITE_NAME:-or-travel}
LOCAL_SITES_DIR=${LOCAL_SITES_DIR:-"$HOME/Local Sites"}
DIRECTION="push"
STRATEGY="copy"
DRY_RUN=0
DELETE=1

while [[ $# -gt 0 ]]; do
    case "$1" in
        -s|--site-name)
            [[ $# -lt 2 ]] && { echo "Missing value for $1" >&2; exit 1; }
            SITE_NAME="$2"
            shift 2
            ;;
        -d|--local-sites-dir)
            [[ $# -lt 2 ]] && { echo "Missing value for $1" >&2; exit 1; }
            LOCAL_SITES_DIR="$2"
            shift 2
            ;;
        --push)
            DIRECTION="push"
            shift
            ;;
        --pull)
            DIRECTION="pull"
            shift
            ;;
        --copy)
            STRATEGY="copy"
            shift
            ;;
        --symlink)
            STRATEGY="symlink"
            shift
            ;;
        --dry-run)
            DRY_RUN=1
            shift
            ;;
        --no-delete)
            DELETE=0
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

TARGET_ROOT="$LOCAL_SITES_DIR/$SITE_NAME/app/public"
TARGET_WP_CONTENT="$TARGET_ROOT/wp-content"

if [[ ! -d "$TARGET_WP_CONTENT" ]]; then
    echo "Local site wp-content directory not found at: $TARGET_WP_CONTENT" >&2
    echo "Pass --site-name and/or --local-sites-dir if your site lives elsewhere." >&2
    exit 1
fi

if [[ "$STRATEGY" == "symlink" ]]; then
    if [[ "$DIRECTION" == "pull" ]]; then
        echo "Symlink strategy only works when pushing repo files into Local." >&2
        exit 1
    fi

    BACKUP_PATH="${TARGET_WP_CONTENT}.backup-$(date +%Y%m%d%H%M%S)"

    if [[ -L "$TARGET_WP_CONTENT" ]]; then
        CURRENT_TARGET=$(readlink "$TARGET_WP_CONTENT")
        if [[ "$CURRENT_TARGET" == "$REPO_WP_CONTENT" ]]; then
            echo "Symlink already points to repository wp-content. Nothing to do."
            exit 0
        fi
    fi

    if [[ -e "$TARGET_WP_CONTENT" ]]; then
        echo "Backing up existing wp-content to $BACKUP_PATH"
        mv "$TARGET_WP_CONTENT" "$BACKUP_PATH"
    fi

    ln -s "$REPO_WP_CONTENT" "$TARGET_WP_CONTENT"
    echo "Created symlink: $TARGET_WP_CONTENT -> $REPO_WP_CONTENT"
    exit 0
fi

if ! command -v rsync >/dev/null 2>&1; then
    echo "rsync is required for copy mode. Please install rsync and try again." >&2
    exit 1
fi

if [[ $DRY_RUN -eq 1 ]]; then
    echo "Running in dry-run mode. No changes will be made."
fi

RSYNC_ARGS=(
    --archive
    --human-readable
    --progress
    --exclude '.git/'
    --exclude '.DS_Store'
    --exclude 'uploads/'
    --exclude 'upgrade/'
    --exclude 'cache/'
    --exclude 'backup-db/'
    --exclude 'backups/'
    --exclude 'blogs.dir/'
    --exclude 'plugins/'
    --exclude 'mu-plugins/'
    --exclude 'languages/'
)

if [[ $DELETE -eq 1 ]]; then
    RSYNC_ARGS+=(--delete)
fi

if [[ $DRY_RUN -eq 1 ]]; then
    RSYNC_ARGS+=(--dry-run)
fi

if [[ "$DIRECTION" == "push" ]]; then
    echo "Syncing repository wp-content -> Local site ($TARGET_WP_CONTENT)"
    rsync "${RSYNC_ARGS[@]}" "$REPO_WP_CONTENT/" "$TARGET_WP_CONTENT/"
else
    echo "Syncing Local site -> repository wp-content ($REPO_WP_CONTENT)"
    rsync "${RSYNC_ARGS[@]}" "$TARGET_WP_CONTENT/" "$REPO_WP_CONTENT/"
fi

if [[ $DRY_RUN -eq 1 ]]; then
    echo "Dry-run complete. No files were modified."
else
    echo "Sync complete."
fi
