<?php
// CORS Configuration
header("Access-Control-Allow-Origin: *"); // Changez * par votre domaine si nécessaire
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

// Pour gérer les requêtes OPTIONS pré-volantes (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once('../config/database.php');
require_once('../controllers/UserController.php');

$userController = new UserController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'getAllUsers') {
            $userController->getAllUsers();
        } elseif ($_GET['action'] === 'getUserById' && isset($_GET['id'])) {
            $userId = $_GET['id'];
            $userController->getUserById($userId);
        }
        // Ajouter d'autres actions GET si nécessaire
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées via POST
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'createUser') {
            $userController->createUser($data);
        } elseif ($_GET['action'] === 'login') {
            $userController->login($data);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Récupérer les données envoyées via PUT
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'updateUser' && isset($_GET['id'])) {
            $userId = $_GET['id'];
            $userController->updateUser($userId, $data);
        } elseif ($_GET['action'] === 'updateUserActive' && isset($_GET['id'])) {
            $userId = $_GET['id'];
            $active = $data['actif'];
            $userController->updateUserActive($userId, $active);
            
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['action']) && $_GET['action'] === 'deleteUser' && isset($_GET['id'])) {
        $userId = $_GET['id'];
        $userController->deleteUser($userId);
    }
}
?>
