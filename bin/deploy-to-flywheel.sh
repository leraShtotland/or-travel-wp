#!/usr/bin/env bash
set -euo pipefail

usage() {
    cat <<'USAGE'
Deploy the repository wp-content directory to a Flywheel site over SFTP.

Environment variables (can be set in .env.flywheel):
  FLYWHEEL_SFTP_HOST       Flywheel SFTP hostname
  FLYWHEEL_SFTP_PORT       Flywheel SFTP port (default: 22)
  FLYWHEEL_SFTP_USERNAME   Flywheel SFTP username
  FLYWHEEL_SFTP_PASSWORD   Flywheel SFTP password (if using password auth)
  FLYWHEEL_SFTP_KEY        Path to an SSH private key (if using key auth)
  FLYWHEEL_REMOTE_PATH     Remote wp-content path (default: public/wp-content)

Usage: deploy-to-flywheel.sh [options]

Options:
      --dry-run          Preview the deployment without uploading
      --no-delete        Do not remove remote files that are missing locally
      --only-themes      Deploy only the wp-content/themes directory
      --env-file FILE    Load credentials from the specified env file (default: .env.flywheel)
  -h, --help             Show this help message
USAGE
}

SCRIPT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
REPO_ROOT=$(cd "$SCRIPT_DIR/.." && pwd)
DEFAULT_ENV_FILE="$REPO_ROOT/.env.flywheel"

ENV_FILE="$DEFAULT_ENV_FILE"
DRY_RUN=0
DELETE=1
SCOPE="wp-content"

while [[ $# -gt 0 ]]; do
    case "$1" in
        --dry-run)
            DRY_RUN=1
            shift
            ;;
        --no-delete)
            DELETE=0
            shift
            ;;
        --only-themes)
            SCOPE="wp-content/themes"
            shift
            ;;
        --env-file)
            [[ $# -lt 2 ]] && { echo "Missing value for $1" >&2; exit 1; }
            ENV_FILE="$2"
            shift 2
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

if [[ -f "$ENV_FILE" ]]; then
    set -o allexport
    # shellcheck disable=SC1090
    source "$ENV_FILE"
    set +o allexport
fi

HOST=${FLYWHEEL_SFTP_HOST:-}
PORT=${FLYWHEEL_SFTP_PORT:-22}
USERNAME=${FLYWHEEL_SFTP_USERNAME:-}
PASSWORD=${FLYWHEEL_SFTP_PASSWORD:-}
KEY=${FLYWHEEL_SFTP_KEY:-}
REMOTE_PATH=${FLYWHEEL_REMOTE_PATH:-public/wp-content}

if [[ -z "$HOST" || -z "$USERNAME" ]]; then
    echo "Flywheel host and username must be provided via environment variables or the env file." >&2
    exit 1
fi

if ! command -v lftp >/dev/null 2>&1; then
    echo "lftp is required for deployment. Install it via brew install lftp (macOS) or apt-get install lftp (Debian/Ubuntu)." >&2
    exit 1
fi

LOCAL_PATH="$REPO_ROOT/$SCOPE"
if [[ ! -d "$LOCAL_PATH" ]]; then
    echo "Local path not found: $LOCAL_PATH" >&2
    exit 1
fi

MIRROR_ARGS=("--reverse" "--parallel=4" "--verbose")
if [[ $DELETE -eq 1 ]]; then
    MIRROR_ARGS+=("--delete")
fi
if [[ $DRY_RUN -eq 1 ]]; then
    MIRROR_ARGS+=("--dry-run")
fi

EXCLUDE_ARGS=(
    "--exclude-glob" "uploads/"
    "--exclude-glob" "upgrade/"
    "--exclude-glob" "cache/"
    "--exclude-glob" "backup-db/"
    "--exclude-glob" "backups/"
    "--exclude-glob" "blogs.dir/"
    "--exclude-glob" ".DS_Store"
    "--exclude-glob" "*.log"
)

REMOTE_TARGET="$REMOTE_PATH"
if [[ "$SCOPE" == "wp-content/themes" ]]; then
    REMOTE_TARGET="$REMOTE_PATH/themes"
fi

printf 'Starting Flywheel deployment to %s@%s:%s\n' "$USERNAME" "$HOST" "$REMOTE_TARGET"

MIRROR_CMD="mirror"
for arg in "${MIRROR_ARGS[@]}" "${EXCLUDE_ARGS[@]}"; do
    MIRROR_CMD+=" $(printf '%q' "$arg")"
done
MIRROR_CMD+=" $(printf '%q' "$LOCAL_PATH") $(printf '%q' "$REMOTE_TARGET")"

LFTP_SCRIPT="set sftp:auto-confirm yes"
if [[ -n "$KEY" ]]; then
    LFTP_SCRIPT+=$'\n'
    LFTP_SCRIPT+="set sftp:connect-program \"ssh -a -x -i $KEY\""
fi
LFTP_SCRIPT+=$'\n'
LFTP_SCRIPT+="$MIRROR_CMD"
LFTP_SCRIPT+=$'\nbye\n'

lftp -u "$USERNAME","$PASSWORD" -p "$PORT" "sftp://$HOST" -e "$LFTP_SCRIPT"

if [[ $DRY_RUN -eq 1 ]]; then
    echo "Flywheel deployment dry-run complete."
else
    echo "Flywheel deployment finished."
fi
