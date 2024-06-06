<?php
require_once('../config/database.php');
require_once('../controllers/OffreController.php');

// Créer une instance de l'objet OffreController avec la connexion à la base de données
$offreController = new OffreController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'getAllOffres') {
        // var_dump($offreController);
        $offreController->getAllOffres();
    } elseif ($_GET['action'] === 'getOffreById' && isset($_GET['id'])) {
        $offreId = $_GET['id'];
        $offreController->getOffreById($offreId);
    } elseif ($_GET['action'] === 'getTotalPages') {
        // Assurez-vous de passer le nombre d'éléments par page comme paramètre
        $itemsPerPage = isset($_GET['itemsPerPage']) ? $_GET['itemsPerPage'] : 5; // Par défaut, 10 éléments par page
        $offreController->getTotalPages($itemsPerPage);
        var_dump($offreController);
        die();
    }
    // Ajouter d'autres actions GET si nécessaire
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gérer les requêtes POST pour la création d'un utilisateur
    // Récupérer les données envoyées via POST
    $data = json_decode(file_get_contents("php://input"), true);

    if ($_GET['action'] === 'createOffre') {
        $offreController->createOffre($data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Gérer les requêtes PUT pour la mise à jour d'un utilisateur
    // Récupérer les données envoyées via PUT
    $data = json_decode(file_get_contents("php://input"), true);

    if ($_GET['action'] === 'updateOffre' && isset($_GET['id'])) {
        $offreId = $_GET['id'];
        $offreController->updateOffre($offreId, $data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Gérer les requêtes DELETE pour la suppression d'un utilisateur
    if ($_GET['action'] === 'deleteOffre' && isset($_GET['id'])) {
        $offreId = $_GET['id'];
        $offreController->deleteOffre($offreId);
    }
}
