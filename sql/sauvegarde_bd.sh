#!/bin/bash
# =====================================================
# Script de sauvegarde de la base de données GSB
# =====================================================
# Usage : ./sauvegarde_bd.sh
# Prérequis : mysqldump doit être installé et accessible
# =====================================================

# Configuration
DB_HOST="localhost"
DB_USER="root"
DB_PASS=""
DB_NAME="gsb_site"

# Répertoire de sauvegarde
BACKUP_DIR="./backups"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="${BACKUP_DIR}/gsb_site_backup_${DATE}.sql"

# Créer le répertoire de sauvegarde s'il n'existe pas
mkdir -p "$BACKUP_DIR"

echo "=========================================="
echo "  Sauvegarde de la base de données GSB"
echo "=========================================="
echo ""
echo "Base de données : $DB_NAME"
echo "Date            : $(date '+%d/%m/%Y %H:%M:%S')"
echo "Fichier         : $BACKUP_FILE"
echo ""

# Exécuter la sauvegarde
if [ -z "$DB_PASS" ]; then
    mysqldump -h "$DB_HOST" -u "$DB_USER" --databases "$DB_NAME" \
              --add-drop-database --add-drop-table \
              --routines --triggers \
              --single-transaction \
              --set-charset > "$BACKUP_FILE" 2>&1
else
    mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" --databases "$DB_NAME" \
              --add-drop-database --add-drop-table \
              --routines --triggers \
              --single-transaction \
              --set-charset > "$BACKUP_FILE" 2>&1
fi

# Vérifier le résultat
if [ $? -eq 0 ]; then
    # Compresser la sauvegarde
    gzip "$BACKUP_FILE"
    BACKUP_FILE="${BACKUP_FILE}.gz"

    SIZE=$(du -h "$BACKUP_FILE" | cut -f1)
    echo "[OK] Sauvegarde réussie !"
    echo "     Taille : $SIZE"
    echo "     Fichier : $BACKUP_FILE"

    # Nettoyer les sauvegardes de plus de 30 jours
    find "$BACKUP_DIR" -name "gsb_site_backup_*.sql.gz" -mtime +30 -delete
    echo ""
    echo "[INFO] Les sauvegardes de plus de 30 jours ont été supprimées."
else
    echo "[ERREUR] La sauvegarde a échoué !"
    echo "         Vérifiez les paramètres de connexion."
    rm -f "$BACKUP_FILE"
    exit 1
fi

echo ""
echo "=========================================="
echo "  Sauvegarde terminée"
echo "=========================================="
