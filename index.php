<?php
/**
 * INDEX.PHP - Point d'entrée de l'application GSB (Front Controller)
 * Structure MVC : route les requêtes vers les contrôleurs appropriés
 */

session_start();

// Inclusion du modèle et des contrôleurs
require_once "modele/modele.php";
require_once "controleur/controleurs.php";

// Routage des actions
$action = $_GET["action"] ?? $_POST["action"] ?? "accueil";

switch ($action) {
    case 'accueil':
        accueil();
        break;

    case 'medicaments':
        getAllMedicaments();
        break;

    case 'detail_medicament':
        getDetailMedicament();
        break;

    case 'activites':
        getAllActivites();
        break;

    case 'detail_activite':
        getDetailActivite();
        break;

    case 'inscrire':
        inscrire();
        break;

    case 'mentions_legales':
        mentionsLegales();
        break;

    default:
        accueil();
        break;
}
?>
