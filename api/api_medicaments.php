<?php
/**
 * API REST - Médicaments GSB
 * Gère les opérations CRUD sur les médicaments
 *
 * GET    /api/api_medicaments.php          -> Liste tous les médicaments
 * GET    /api/api_medicaments.php?id=X     -> Détail d'un médicament (avec effets et interactions)
 * POST   /api/api_medicaments.php          -> Ajouter un médicament
 * PUT    /api/api_medicaments.php?id=X     -> Modifier un médicament
 * DELETE /api/api_medicaments.php?id=X     -> Supprimer un médicament
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
            getMedicament($id);
        } else {
            getMedicaments();
        }
        break;

    case 'POST':
        addMedicament();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        updateMedicament($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        deleteMedicament($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['status' => 0, 'status_message' => 'Méthode non autorisée']);
        break;
}

/**
 * Récupère la liste de tous les médicaments
 */
function getMedicaments()
{
    global $conn;
    $query = "SELECT * FROM medicaments ORDER BY nom ASC";
    $result = $conn->query($query);
    $response = $result->fetchAll();
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * Récupère le détail d'un médicament avec ses effets et interactions
 */
function getMedicament($id)
{
    global $conn;

    // Médicament
    $stmt = $conn->prepare("SELECT * FROM medicaments WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $medicament = $stmt->fetch();

    if (!$medicament) {
        http_response_code(404);
        echo json_encode(['status' => 0, 'status_message' => 'Médicament non trouvé']);
        return;
    }

    // Effets thérapeutiques
    $stmt = $conn->prepare("SELECT * FROM effets_therapeutiques WHERE id_medicament = :id");
    $stmt->execute([':id' => $id]);
    $medicament['effets_therapeutiques'] = $stmt->fetchAll();

    // Effets secondaires
    $stmt = $conn->prepare("SELECT * FROM effets_secondaires WHERE id_medicament = :id");
    $stmt->execute([':id' => $id]);
    $medicament['effets_secondaires'] = $stmt->fetchAll();

    // Interactions avec d'autres médicaments
    $stmt = $conn->prepare("
        SELECT i.*,
            CASE
                WHEN i.id_medicament_1 = :id THEN m2.nom
                ELSE m1.nom
            END AS nom_medicament_interaction
        FROM interactions i
        JOIN medicaments m1 ON i.id_medicament_1 = m1.id
        JOIN medicaments m2 ON i.id_medicament_2 = m2.id
        WHERE i.id_medicament_1 = :id2 OR i.id_medicament_2 = :id3
    ");
    $stmt->execute([':id' => $id, ':id2' => $id, ':id3' => $id]);
    $medicament['interactions'] = $stmt->fetchAll();

    echo json_encode($medicament, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * Ajoute un nouveau médicament
 */
function addMedicament()
{
    global $conn;
    $nom = $_POST["nom"] ?? '';
    $description = $_POST["description"] ?? '';
    $composition = $_POST["composition"] ?? '';
    $forme = $_POST["forme"] ?? '';
    $prix = $_POST["prix"] ?? 0;

    $stmt = $conn->prepare("INSERT INTO medicaments (nom, description, composition, forme, prix)
                            VALUES (:nom, :description, :composition, :forme, :prix)");

    if ($stmt->execute([
        ':nom' => $nom,
        ':description' => $description,
        ':composition' => $composition,
        ':forme' => $forme,
        ':prix' => $prix
    ])) {
        echo json_encode([
            'status' => 1,
            'status_message' => 'Médicament ajouté avec succès.',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de l\'ajout.']);
    }
}

/**
 * Met à jour un médicament existant
 */
function updateMedicament($id)
{
    global $conn;
    $_PUT = [];
    parse_str(file_get_contents('php://input'), $_PUT);

    $nom = $_PUT["nom"] ?? '';
    $description = $_PUT["description"] ?? '';
    $composition = $_PUT["composition"] ?? '';
    $forme = $_PUT["forme"] ?? '';
    $prix = $_PUT["prix"] ?? 0;

    $stmt = $conn->prepare("UPDATE medicaments SET nom=:nom, description=:description,
                            composition=:composition, forme=:forme, prix=:prix WHERE id=:id");

    if ($stmt->execute([
        ':nom' => $nom, ':description' => $description,
        ':composition' => $composition, ':forme' => $forme,
        ':prix' => $prix, ':id' => $id
    ])) {
        echo json_encode(['status' => 1, 'status_message' => 'Médicament mis à jour avec succès.']);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de la mise à jour.']);
    }
}

/**
 * Supprime un médicament
 */
function deleteMedicament($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM medicaments WHERE id = :id");

    if ($stmt->execute([':id' => $id])) {
        echo json_encode(['status' => 1, 'status_message' => 'Médicament supprimé avec succès.']);
    } else {
        echo json_encode(['status' => 0, 'status_message' => 'Erreur lors de la suppression.']);
    }
}
?>
