<?php
/**
 * MODÈLE - Couche d'accès aux données via l'API REST
 * Toutes les fonctions communiquent avec l'API REST pour accéder à la BD
 */

// URL de base de l'API (à adapter selon votre configuration)
define('API_BASE_URL', 'http://127.0.0.1/GSB_Site/api');

// =====================================================
// MÉDICAMENTS
// =====================================================

/**
 * Récupère la liste de tous les médicaments
 * @return string JSON des médicaments
 */
function selectMedicaments()
{
    $url = API_BASE_URL . '/api_medicaments.php';
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET'
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

/**
 * Récupère le détail d'un médicament (avec effets et interactions)
 * @param int $id Identifiant du médicament
 * @return string JSON du médicament
 */
function selectMedicament($id)
{
    $url = API_BASE_URL . '/api_medicaments.php?id=' . $id;
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET'
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

// =====================================================
// ACTIVITÉS
// =====================================================

/**
 * Récupère la liste de toutes les activités
 * @return string JSON des activités
 */
function selectActivites()
{
    $url = API_BASE_URL . '/api_activites.php';
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET'
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

/**
 * Récupère le détail d'une activité
 * @param int $id Identifiant de l'activité
 * @return string JSON de l'activité
 */
function selectActivite($id)
{
    $url = API_BASE_URL . '/api_activites.php?id=' . $id;
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET'
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

// =====================================================
// INSCRIPTIONS
// =====================================================

/**
 * Inscrit un participant à une activité
 * @param int $id_activite Identifiant de l'activité
 * @param string $nom Nom du participant
 * @param string $prenom Prénom du participant
 * @param string $email Email du participant
 * @param string $telephone Téléphone du participant
 * @return string JSON de la réponse
 */
function inscrireActivite($id_activite, $nom, $prenom, $email, $telephone)
{
    $url = API_BASE_URL . '/api_inscriptions.php';
    $data = [
        'id_activite' => $id_activite,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone
    ];
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

/**
 * Récupère les inscriptions d'une activité
 * @param int $id_activite Identifiant de l'activité
 * @return string JSON des inscriptions
 */
function selectInscriptions($id_activite)
{
    $url = API_BASE_URL . '/api_inscriptions.php?id_activite=' . $id_activite;
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET'
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
?>
