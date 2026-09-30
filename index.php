<?php
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// POINT 1 : Liste des étudiants
if ($method === 'GET' && $action === 'liste_etudiants') {
    $stmt = $pdo->query("SELECT * FROM etudiants");
    echo json_encode($stmt->fetchAll());
    exit;
}

// POINT 2 : Matières d'un étudiant
if ($method === 'GET' && $action === 'matieres_etudiant') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt = $pdo->prepare("SELECT DISTINCT m.id, m.nom_matiere FROM matieres m JOIN notes n ON m.id = n.matiere_id WHERE n.etudiant_id = ?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetchAll());
    exit;
}

// POINT 3 : Notes d'un étudiant
if ($method === 'GET' && $action === 'notes_etudiant') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt = $pdo->prepare("SELECT m.nom_matiere, n.note FROM notes n JOIN matieres m ON n.matiere_id = m.id WHERE n.etudiant_id = ?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetchAll());
    exit;
}

// POINT 4 : Ajout d'un étudiant
if ($method === 'POST' && $action === 'ajout_etudiant') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['nom'], $data['prenom'], $data['email'])) {
        $stmt = $pdo->prepare("INSERT INTO etudiants (nom, prenom, email) VALUES (?, ?, ?)");
        $stmt->execute([$data['nom'], $data['prenom'], $data['email']]);
        echo json_encode(["message" => "Etudiant ajouté avec succès"]);
    } else {
        echo json_encode(["erreur" => "Données incomplètes"]);
    }
    exit;
}

// POINT 5 : Ajout d'une note
if ($method === 'POST' && $action === 'ajout_note') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['etudiant_id'], $data['matiere_id'], $data['note'])) {
        $stmt = $pdo->prepare("INSERT INTO notes (etudiant_id, matiere_id, note) VALUES (?, ?, ?)");
        $stmt->execute([$data['etudiant_id'], $data['matiere_id'], $data['note']]);
        echo json_encode(["message" => "Note ajoutée avec succès"]);
    } else {
        echo json_encode(["erreur" => "Données incomplètes"]);
    }
    exit;
}

// BONUS : Liste des matières
if ($method === 'GET' && $action === 'liste_matieres') {
    $stmt = $pdo->query("SELECT * FROM matieres");
    echo json_encode($stmt->fetchAll());
    exit;
}
// ==========================================
// POINT 6 : Supprimer un étudiant (DELETE)
// ==========================================
if ($method === 'DELETE' && $action === 'supprimer_etudiant') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = isset($data['id']) ? intval($data['id']) : 0;

    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM etudiants WHERE id = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(["message" => "Etudiant supprimé avec succès"]);
        }
    } else {
        echo json_encode(["erreur" => "ID invalide"]);
    }
    exit;
}

// ==========================================
// POINT 7 : Modifier un étudiant (PUT)
// ==========================================
if ($method === 'PUT' && $action === 'modifier_etudiant') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['id'], $data['nom'], $data['prenom'], $data['email'])) {
        $stmt = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ?, email = ? WHERE id = ?");
        if ($stmt->execute([$data['nom'], $data['prenom'], $data['email'], $data['id']])) {
            echo json_encode(["message" => "Etudiant modifié avec succès"]);
        }
    } else {
        echo json_encode(["erreur" => "Données incomplètes"]);
    }
    exit;
}
http_response_code(404);
echo json_encode(["erreur" => "Action non reconnue"]);
?>