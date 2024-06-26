<?php

require_once('../config/database.php');

class Offre {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllOffres($page, $itemsPerPage, $searchQuery = null) {
        // Préparer la requête SQL de base pour récupérer tous les offres paginés
        $query = "SELECT * FROM offres";
    
        // Ajouter une condition de recherche si un terme de recherche est spécifié
        if ($searchQuery !== null) {
            $searchParam = '%' . $searchQuery . '%';
            $query .= " WHERE titre LIKE :searchParam 
                        OR description LIKE :searchParam 
                        OR entreprise LIKE :searchParam 
                        OR lieu LIKE :searchParam";
        }
    
        // Ajouter la pagination à la requête SQL
        $query .= " LIMIT :offset, :itemsPerPage";
    
        try {
            $offset = ($page - 1) * $itemsPerPage;
            $statement = $this->db->prepare($query);
    
            // Associer les valeurs aux paramètres de la requête
            $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
            $statement->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    
            // Ajouter les valeurs pour la recherche si nécessaire
            if ($searchQuery !== null) {
                $statement->bindParam(':searchParam', $searchParam);
            }
    
            $statement->execute();
            $offres = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $offres;
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return array();
        }
    }
    
    
    public function getTotalPages($itemsPerPage) {
        try {
            $query = "SELECT COUNT(*) AS total FROM offres";
            $statement = $this->db->query($query);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $totalItems = $result['total'];
            return ceil($totalItems / $itemsPerPage);
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return 1; // Par défaut, s'il y a une erreur, retourner 1 page
        }
    }
    

    public function getOffreById($offreId) {
        // Récupérer une offre par son ID depuis la base de données
        try {
            $query = "SELECT * FROM offres WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $offreId);
            $statement->execute();
            $offre = $statement->fetch(PDO::FETCH_ASSOC);
            return $offre;
        } catch (PDOException $e) {
            return array();
        }
    }

    public function createOffre($offreData) {
        // Créer une nouvelle offre dans la base de données avec les données fournies
        try {
            $query = "INSERT INTO `offres` (`titre`, `url`, `description`,
             `statut`, `entreprise`, `lieu`, `user_id`) VALUES (:titre, :url, :description,
            :statut, :entreprise, :lieu, :user_id)";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':titre', $offreData['titre']);
            $statement->bindParam(':url', $offreData['url']);
            // $statement->bindParam(':created_at', $offreData['created_at']);
            $statement->bindParam(':description', $offreData['description']);
            $statement->bindParam(':statut', $offreData['statut']);
            $statement->bindParam(':entreprise', $offreData['entreprise']);
            $statement->bindParam(':lieu', $offreData['lieu']);
            $statement->bindParam(':user_id', $offreData['user_id']);

            $statement->execute();
            
            // Renvoyer l'ID du nouvel utilisateur créé
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
             // Loguer l'erreur dans un fichier de log
        error_log('Erreur lors de la création de l\'offre : ' . $e->getMessage());

        // Optionnel: Vous pouvez également afficher l'erreur pour le débogage (ne pas utiliser en production)
        // echo 'Erreur: ' . $e->getMessage();

        // Retourner un message d'erreur significatif
        return ['error' => 'Une erreur est survenue lors de la création de l\'offre. Veuillez réessayer plus tard.'];
        }
    }

    public function updateOffre($offreId, $newOffreData) {
        // Mettre à jour les informations d'une offre spécifique dans la base de données
        try {
            $query = "UPDATE offres SET titre = :titre, url = :url, created_at = :created_at, description = :description, statut = :statut, entreprise = :entreprise,
            lieu = :lieu WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $offreId);
            $statement->bindParam(':titre', $newOffreData['titre']);
            $statement->bindParam(':created_at', $newOffreData['created_at']);
            $statement->bindParam(':url', $newOffreData['url']); 
            $statement->bindParam(':description', $newOffreData['description']);
            $statement->bindParam(':statut', $newOffreData['statut']);
            $statement->bindParam(':entreprise', $newOffreData['entreprise']);
            $statement->bindParam(':lieu', $newOffreData['lieu']);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            error_log('Erreur lors de la mise à jour de l\'offre : ' . $e->getMessage());

            return false;
        }
    }

    public function deleteOffre($offreId) {
        // Supprimer une offre de la base de données
        try {
            $query = "DELETE FROM offres WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $offreId);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de requête
            return false;
        }
    }

}