<?php
/**
 * CONTRÔLEURS - Logique métier de l'application GSB
 * Récupère les données via le modèle et charge les vues appropriées
 */

/**
 * Affiche la page d'accueil
 */
function accueil()
{
    include("vues/vue_accueil.php");
}

/**
 * Affiche la liste de tous les médicaments
 */
function getAllMedicaments()
{
    $medicamentsJSON = selectMedicaments(); // modèle
    $medicaments = json_decode($medicamentsJSON, true);
    include("vues/vue_medicaments.php");
}

/**
 * Affiche le détail d'un médicament avec ses effets et interactions
 */
function getDetailMedicament()
{
    $id = intval($_GET["id"]);
    $medicamentJSON = selectMedicament($id); // modèle
    $medicament = json_decode($medicamentJSON, true);

    if (!$medicament || isset($medicament['status'])) {
        $erreur = "Médicament non trouvé.";
        include("vues/vue_erreur.php");
        return;
    }
    include("vues/vue_detail_medicament.php");
}

/**
 * Affiche la liste de toutes les activités
 */
function getAllActivites()
{
    $activitesJSON = selectActivites(); // modèle
    $activites = json_decode($activitesJSON, true);
    include("vues/vue_activites.php");
}

/**
 * Affiche le détail d'une activité avec formulaire d'inscription
 */
function getDetailActivite()
{
    $id = intval($_GET["id"]);
    $activiteJSON = selectActivite($id); // modèle
    $activite = json_decode($activiteJSON, true);

    if (!$activite || isset($activite['status'])) {
        $erreur = "Activité non trouvée.";
        include("vues/vue_erreur.php");
        return;
    }
    include("vues/vue_detail_activite.php");
}

/**
 * Gère l'inscription à une activité
 */
function inscrire()
{
    $id_activite = intval($_POST["id_activite"]);
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"] ?? '');

    $resultJSON = inscrireActivite($id_activite, $nom, $prenom, $email, $telephone); // modèle
    $result = json_decode($resultJSON, true);

    // Recharger la page de l'activité avec le message
    $activiteJSON = selectActivite($id_activite);
    $activite = json_decode($activiteJSON, true);
    $message_inscription = $result;

    include("vues/vue_detail_activite.php");
}

/**
 * Affiche les mentions légales
 */
function mentionsLegales()
{
    include("vues/vue_mentions_legales.php");
}
?>
