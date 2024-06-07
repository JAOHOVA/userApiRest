<?php
require_once('../models/Offre.php');

class OffreController {
    private $offreModel;

    public function __construct($db) {
        $this->offreModel = new Offre($db);
    }

    public function getAllOffres($page, $itemsPerPage) {
        // Appeler la méthode du modèle pour récupérer tous les offres paginés
        $offres = $this->offreModel->getAllOffres($page, $itemsPerPage);
        // Traiter les données récupérées, les envoyer en tant que réponse JSON
        header('Content-Type: application/json');
        echo json_encode($offres);
    }

    public function getTotalPages($itemsPerPage) {
        // Récupérer le nombre total de pages pour la pagination
        $totalPages = $this->offreModel->getTotalPages($itemsPerPage);
        header('Content-Type: application/json');
        echo json_encode(['total_pages' => $totalPages]);
    }

    public function getOffreById($offreId) {
        $offre = $this->offreModel->getOffreById($offreId);
        header('Content-Type: application/json');
        echo json_encode($offre);
    }

    public function createOffre($offreData) {
        $newOffreId = $this->offreModel->createOffre($offreData);

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Offre créée avec l\'ID : ' .$newOffreId]);

    }

    public function updateOffre($offreId, $newOffreData) {
        // Appeler la méthode du modèle pour mettre à jour une offre
        $result = $this->offreModel->updateOffre($offreId, $newOffreData);

        header('Content-Type: application/json');
        // echo json_encode(['success' => $result]);
        if ($result) {
            echo json_encode(["message" => "Offre mis à jour avec succès"]);
        } else {
            echo json_encode(["message" => "Erreur lors de la mise à jour de l'offre"]);
        }
    }

    public function deleteOffre($offreId) {
        // Appeler la méthode du modèle pour supprimer une offre
        $success = $this->offreModel->deleteOffre($offreId);
        if ($success) {
            echo json_encode(array("message" => "Offre supprimé avec succès"));
        } else {
            echo json_encode(array("message" => "Erreur lors de la suppression de l'Offre"));
        }
    }

    /* public function getTotalPages($itemsPerPage) {
        $totalPages = $this->offreModel->getTotalPages($itemsPerPage);
        header('Content-Type: application/json');
        // echo json_encode(['success' => $totalPages]);
        if ($totalPages) {
            echo json_encode(["message" => "Total d'offre avec succès"]);
        } else {
            echo json_encode(["message" => "Erreur lors de l'envoie de total d'offre"]);
        }
    } */
}