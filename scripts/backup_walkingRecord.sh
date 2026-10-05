#!/bin/zsh

BACKUP_DIR="$HOME/walkingRecord_backups"

# Set the path to mysqldump for your local environment.
MYSQLDUMP="/path/to/mysqldump"

DATE=$(date +"%Y-%m-%d_%H-%M-%S")
BACKUP_FILE="$BACKUP_DIR/walkingRecord_backup_$DATE.sql"

mkdir -p "$BACKUP_DIR"

"$MYSQLDUMP" \
  -h 127.0.0.1 \
  -P 3306 \
  -u root \
  walkingRecord \
  > "$BACKUP_FILE"

if [ $? -eq 0 ]; then
    find "$BACKUP_DIR" -name "walkingRecord_backup_*.sql" -type f -mtime +10 -delete
else
    rm -f "$BACKUP_FILE"
    exit 1
fi
