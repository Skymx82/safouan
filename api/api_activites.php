<?php
/**
 * API REST - Activités GSB
 * Gère les opérations CRUD sur les activités complémentaires
 *
 * GET    /api/api_activites.php           -> Liste toutes les activités
 * GET    /api/api_activites.php?id=X      -> Détail d'une activité
 * POST   /api/api_activites.php           -> Ajouter une activité
 * PUT    /api/api_activites.php?id=X      -> Modifier une activité
 * DELETE /api/api_activites.php?id=X      -> Supprimer une activité
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include("db_connect.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getActivite($id);
        } else {
            getActivites();
        }
        break;

    case 'POST':
        addActivite();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        updateActivite($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        deleteActivite($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['status' => 0, 'status_message' => 'Méthode non autorisée']);
        break;
}

/**
 * Récupère toutes les activités
 */
function getActivites()
{
    global $conn;
    $query = "SELECT * FROM activites ORDER BY date_activite ASC";
    $result = $conn->query($query);
    $response = $result->fetchAll();
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * Récupère le détail d'une activité avec le nombre d'inscrits
 */
function getActivite($id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM activites WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $activite = $stmt->fetch();

    if (!$activite) {
        http_response_code(404);
        echo json_encode(['status' => 0, 'status_message' => 'Activité non trouvée']);
        return;
    }

    // Nombre d'inscrits
    $stmt = $conn->prepare("SELECT COUNT(*) as nb_inscrits FROM inscriptions WHERE id_activite = :id");
    $stmt->execute([':id' => $id]);
    $count = $stmt->fetch();
    $activite['nb_inscrits'] = $count['nb_inscrits'];

    echo json_encode($activite, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * Ajoute une nouvelle activité
 */
function addActivite()
{
    global $conn;
    $nom = $_POST["nom"] ?? '';
    $description = $_POST["description"] ?? '';
    $date_activite = $_POST["date_activite"] ?? '';
    $lieu = $_POST["lieu"] ?? '';
    $places_max = $_POST["places_max"] ?? 0;

    $stmt = $conn->prepare("INSERT INTO activites (nom, description, date_activite, lieu, places_max, places_restantes)
                            VALUES (:nom, :description, :date_activite, :lieu, :places_max, :places_restantes)");

    if ($stmt->execute([
        ':nom' => $nom, ':description' => $description,
        ':date_activite' => $date_activite, ':lieu' => $lieu,
        ':places_max' => $places_max, ':places_restantes' => $places_max
    ])) {
        echo json_encode(['status' => 1, 'status_message' => 'Activité ajoutée avec succès.', 'id' => $conn->lastInsertId()]);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de l\'ajout.']);
    }
}

/**
 * Met à jour une activité existante
 */
function updateActivite($id)
{
    global $conn;
    $_PUT = [];
    parse_str(file_get_contents('php://input'), $_PUT);

    $nom = $_PUT["nom"] ?? '';
    $description = $_PUT["description"] ?? '';
    $date_activite = $_PUT["date_activite"] ?? '';
    $lieu = $_PUT["lieu"] ?? '';
    $places_max = $_PUT["places_max"] ?? 0;

    $stmt = $conn->prepare("UPDATE activites SET nom=:nom, description=:description,
                            date_activite=:date_activite, lieu=:lieu, places_max=:places_max WHERE id=:id");

    if ($stmt->execute([
        ':nom' => $nom, ':description' => $description,
        ':date_activite' => $date_activite, ':lieu' => $lieu,
        ':places_max' => $places_max, ':id' => $id
    ])) {
        echo json_encode(['status' => 1, 'status_message' => 'Activité mise à jour avec succès.']);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de la mise à jour.']);
    }
}

/**
 * Supprime une activité
 */
function deleteActivite($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM activites WHERE id = :id");

    if ($stmt->execute([':id' => $id])) {
        echo json_encode(['status' => 1, 'status_message' => 'Activité supprimée avec succès.']);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de la suppression.']);
    }
}
?>
