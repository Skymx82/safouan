<?php
/**
 * Script de sauvegarde de la base de données GSB (version PHP)
 * Alternative au script shell pour les environnements Windows
 *
 * Usage : php sauvegarde_bd.php
 */

// Configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'gsb_site';
$backup_dir = __DIR__ . '/backups';
$date = date('Ymd_His');
$backup_file = $backup_dir . '/gsb_site_backup_' . $date . '.sql';

// Créer le répertoire de sauvegarde
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0755, true);
}

echo "==========================================\n";
echo "  Sauvegarde de la base de données GSB\n";
echo "==========================================\n\n";
echo "Base de données : $db_name\n";
echo "Date            : " . date('d/m/Y H:i:s') . "\n";
echo "Fichier         : $backup_file\n\n";

// Commande mysqldump
$cmd = sprintf(
    'mysqldump -h %s -u %s %s --databases %s --add-drop-database --add-drop-table --routines --triggers --single-transaction --set-charset > %s 2>&1',
    escapeshellarg($db_host),
    escapeshellarg($db_user),
    empty($db_pass) ? '' : '-p' . escapeshellarg($db_pass),
    escapeshellarg($db_name),
    escapeshellarg($backup_file)
);

exec($cmd, $output, $return_code);

if ($return_code === 0 && file_exists($backup_file) && filesize($backup_file) > 0) {
    echo "[OK] Sauvegarde réussie !\n";
    echo "     Taille : " . round(filesize($backup_file) / 1024, 2) . " Ko\n";
    echo "     Fichier : $backup_file\n\n";

    // Nettoyer les vieilles sauvegardes (> 30 jours)
    $files = glob($backup_dir . '/gsb_site_backup_*.sql');
    foreach ($files as $file) {
        if (filemtime($file) < time() - 30 * 24 * 3600) {
            unlink($file);
            echo "[INFO] Ancienne sauvegarde supprimée : " . basename($file) . "\n";
        }
    }
} else {
    echo "[ERREUR] La sauvegarde a échoué !\n";
    echo "         Vérifiez les paramètres de connexion et que mysqldump est accessible.\n";
    if (file_exists($backup_file)) {
        unlink($backup_file);
    }
    exit(1);
}

echo "\n==========================================\n";
echo "  Sauvegarde terminée\n";
echo "==========================================\n";
?>
