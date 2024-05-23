<?php

require_once('../config/database.php');

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        // Récupérer tous les utilisateurs depuis la base de données
        try {
            $query = "SELECT * FROM user";
            $statement = $this->db->query($query);
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return array();
        }
    }

    public function getUserById($userId) {
        // Récupérer un utilisateur par son ID depuis la base de données
        try {
            $query = "SELECT * FROM user WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $userId);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            return array();
        }
    }

    public function createUser($userData) {
        // Valider l'adresse e-mail
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            // Adresse e-mail non valide
            return "e-mail non valide";
        }

        // Hacher le mot de passe
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);

        // Créer un nouvel utilisateur dans la base de données avec les données fournies
        try {
            $query = "INSERT INTO user (username, email, password, roles, actif) VALUES (:username, :email, :password, :roles, :actif)";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':username', $userData['username']);
            $statement->bindParam(':email', $userData['email']);
            $statement->bindParam(':password', $hashedPassword);
            $statement->bindParam(':roles', $userData['roles']);
            $statement->bindParam(':actif', $userData['actif'], PDO::PARAM_INT);
            $statement->execute();
            
            // Renvoyer l'ID du nouvel utilisateur créé
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return null;
        }
    }

    public function updateUser($userId, $newUserData) {
        // Valider l'adresse e-mail
        if (!filter_var($newUserData['email'], FILTER_VALIDATE_EMAIL)) {
            // Adresse e-mail non valide
            return "e-mail non valide";
        }

        // Hacher le mot de passe
        $hashedPassword = password_hash($newUserData['password'], PASSWORD_DEFAULT);

        // Mettre à jour les informations d'un utilisateur spécifique dans la base de données
        try {
            $query = "UPDATE user SET username = :username, email = :email, password = :password, roles = :roles, actif = :actif WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $userId);
            $statement->bindParam(':username', $newUserData['username']);
            $statement->bindParam(':email', $newUserData['email']);
            $statement->bindParam(':password', $hashedPassword); // Note : Généralement, pour la mise à jour, le mot de passe n'est pas modifié directement de cette manière, mais cette implémentation dépend de vos besoins.
            $statement->bindParam(':roles', $newUserData['roles']);
            $statement->bindParam(':actif', $newUserData['actif'], PDO::PARAM_INT);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return false;
        }
    }

    public function deleteUser($userId) {
        // Supprimer un utilisateur de la base de données
        try {
            $query = "DELETE FROM user WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $userId);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return false;
        }
    }

     // Ajouter la méthode de mise à jour de l'état actif
     public function updateUserActive($userId, $active) {
        // Mettre à jour l'état actif d'un utilisateur spécifique dans la base de données
        try {
            $query = "UPDATE user SET actif = :actif WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $userId);
            $statement->bindParam(':actif', $active, PDO::PARAM_INT);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return false;
        }
    }

    // Ajouter la méthode de login
    public function login($userData) {
        $email = $userData['email'];
        $password = $userData['password'];

        // Rechercher l'utilisateur par email
        $query = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Générer un jeton JWT
            $token = $this->generateJWT($user['id']);

            // Répondre avec le token et les informations utilisateur
            return [
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ]
            ];
        } else {
            return ['error' => 'Invalid credentials'];
        }
    }

    private function generateJWT($userId) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['user_id' => $userId, 'exp' => time() + (60 * 60)]); // 1 heure d'expiration
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'your_secret_key', true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }
}

