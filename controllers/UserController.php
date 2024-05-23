<?php
require_once('../models/User.php');
// Traiter les données récupérées, par exemple, les envoyer en tant que réponse JSON
header('Content-Type: application/json');

class UserController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function getAllUsers() {
        $users = $this->user->getAllUsers();
        // Traiter les données récupérées, par exemple, les envoyer en tant que réponse JSON
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function getUserById($userId) {
        $user = $this->user->getUserById($userId);
        header('Content-Type: application/json');
        echo json_encode($user);
    }

    public function createUser($userData) {
        $result = $this->user->createUser($userData);
        header('Content-Type: application/json');
        echo json_encode(['userId' => $result]);
    }

    public function updateUser($userId, $userData) {
        $result = $this->user->updateUser($userId, $userData);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function deleteUser($userId) {
        $result = $this->user->deleteUser($userId);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

     // Ajouter la méthode updateUserActive
     public function updateUserActive($userId, $active) {
        $result = $this->user->updateUserActive($userId, $active);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    // Ajouter la méthode de login
    public function login($userData) {
        $result = $this->user->login($userData);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}

