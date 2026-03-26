<?php
/**
 * API REST - Inscriptions aux activités GSB
 *
 * GET    /api/api_inscriptions.php?id_activite=X  -> Liste des inscrits à une activité
 * POST   /api/api_inscriptions.php                -> Inscrire un participant
 * DELETE /api/api_inscriptions.php?id=X           -> Supprimer une inscription
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');

include("db_connect.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id_activite"])) {
            $id_activite = intval($_GET["id_activite"]);
            getInscriptions($id_activite);
        } else {
            echo json_encode(['status' => 0, 'status_message' => 'Paramètre id_activite requis']);
        }
        break;

    case 'POST':
        addInscription();
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        deleteInscription($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['status' => 0, 'status_message' => 'Méthode non autorisée']);
        break;
}

/**
 * Liste les inscrits à une activité
 */
function getInscriptions($id_activite)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM inscriptions WHERE id_activite = :id ORDER BY date_inscription DESC");
    $stmt->execute([':id' => $id_activite]);
    $response = $stmt->fetchAll();
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * Inscrit un participant à une activité
 */
function addInscription()
{
    global $conn;

    $id_activite = $_POST["id_activite"] ?? 0;
    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $email = $_POST["email"] ?? '';
    $telephone = $_POST["telephone"] ?? '';

    // Vérifier les places restantes
    $stmt = $conn->prepare("SELECT places_restantes FROM activites WHERE id = :id");
    $stmt->execute([':id' => $id_activite]);
    $activite = $stmt->fetch();

    if (!$activite) {
        echo json_encode(['status' => 0, 'status_message' => 'Activité non trouvée.']);
        return;
    }

    if ($activite['places_restantes'] <= 0) {
        echo json_encode(['status' => 0, 'status_message' => 'Plus de places disponibles pour cette activité.']);
        return;
    }

    // Vérifier si l'email est déjà inscrit à cette activité
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM inscriptions WHERE id_activite = :id_activite AND email = :email");
    $stmt->execute([':id_activite' => $id_activite, ':email' => $email]);
    $check = $stmt->fetch();

    if ($check['count'] > 0) {
        echo json_encode(['status' => 0, 'status_message' => 'Cet email est déjà inscrit à cette activité.']);
        return;
    }

    // Inscrire le participant
    $stmt = $conn->prepare("INSERT INTO inscriptions (id_activite, nom, prenom, email, telephone)
                            VALUES (:id_activite, :nom, :prenom, :email, :telephone)");

    if ($stmt->execute([
        ':id_activite' => $id_activite, ':nom' => $nom,
        ':prenom' => $prenom, ':email' => $email, ':telephone' => $telephone
    ])) {
        // Décrémenter les places restantes
        $conn->prepare("UPDATE activites SET places_restantes = places_restantes - 1 WHERE id = :id")
             ->execute([':id' => $id_activite]);

        echo json_encode([
            'status' => 1,
            'status_message' => 'Inscription réussie !',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de l\'inscription.']);
    }
}

/**
 * Supprime une inscription
 */
function deleteInscription($id)
{
    global $conn;

    // Récupérer l'activité pour remettre la place
    $stmt = $conn->prepare("SELECT id_activite FROM inscriptions WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $inscription = $stmt->fetch();

    $stmt = $conn->prepare("DELETE FROM inscriptions WHERE id = :id");
    if ($stmt->execute([':id' => $id])) {
        if ($inscription) {
            $conn->prepare("UPDATE activites SET places_restantes = places_restantes + 1 WHERE id = :id")
                 ->execute([':id' => $inscription['id_activite']]);
        }
        echo json_encode(['status' => 1, 'status_message' => 'Inscription supprimée avec succès.']);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de la suppression.']);
    }
}
?>
