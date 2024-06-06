<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Template</title>
<link rel="stylesheet" href="public/styleOffre.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Barre de navigation -->
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home.php">Mes offres</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" data-page="home" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-page="admin" href="admin.php">Accueil de l'admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-page="utilisateur" href="utilisateur.php">Utilisateur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-page="offre" href="offre.php">Offre</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto" id="authLinks">
                    <!-- Auth links will be inserted here by JavaScript -->
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-5">

    <!-- Message de confiramtion -->
    <div id="message" class="text-center" style="margin-top: 74px";></div>

    <h1 class="text-center" style="margin-top: 62px";>Liste des utilisateurs</h1>
    
    <!-- Bouton pour afficher le formulaire de création -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createOffreModal">Créer offre</button>

    <!-- Tableau pour afficher la liste des offres -->
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Titre</th>
                <th>Date de création</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Entreprise</th>
                <th>Lieu</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="offreTableBody">
            <!-- Les données des offres seront affichées ici -->
        </tbody>
    </table>
</div>

<!-- Modal de création -->
<div class="modal fade" id="createOffreModal" tabindex="-1" aria-labelledby="createOffreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOffreModalLabel">Créer offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createOffreForm">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="createTitre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="createTitre" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="createUrl" class="form-label">URL</label>
                            <input type="url" class="form-control" id="createUrl">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="createDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="createDescription" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="createStatut" class="form-label">Statut</label>
                            <input type="text" class="form-control" id="createStatut" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="createEntreprise" class="form-label">Entreprise</label>
                            <input type="text" class="form-control" id="createEntreprise" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="createLieu" class="form-label">Lieu</label>
                            <input type="text" class="form-control" id="createLieu" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="createUserId" class="form-label">User ID</label>
                            <input type="number" class="form-control" id="createUserId" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de modification -->
<div class="modal fade" id="editOffreModal" tabindex="-1" aria-labelledby="editOffreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOffreModalLabel">Modifier offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOffreForm">
                    <input type="hidden" id="editOffreId">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editTitre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="editTitre" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editCreatedAt" class="form-label">Date de création</label>
                            <input type="datetime-local" class="form-control" id="editCreatedAt" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editUrl" class="form-label">URL</label>
                            <input type="url" class="form-control" id="editUrl">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editStatut" class="form-label">Statut</label>
                            <input type="text" class="form-control" id="editStatut" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editEntreprise" class="form-label">Entreprise</label>
                            <input type="text" class="form-control" id="editEntreprise" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editLieu" class="form-label">Lieu</label>
                            <input type="text" class="form-control" id="editLieu" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editUserId" class="form-label">User ID</label>
                            <input type="number" class="form-control" id="editUserId" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="text-danger me-2">
                    <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                </span>
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette offre ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de déconnexion -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirmation de déconnexion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Êtes-vous sûr de vouloir vous déconnecter?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="button" class="btn btn-primary" onclick="confirmLogout()">Se déconnecter</button>
        </div>
    </div>
</div>
</div>

<footer class="footer mt-auto py-3 bg-light text-center">
    <div class="container">
        <span class="text-muted">Mon site - Tous droits réservés &copy; 2024</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const currentPage = window.location.pathname.split('/').pop().split('.').shift();
        $(`.nav-link[data-page="${currentPage}"]`).addClass('active');

        const isLoggedIn = localStorage.getItem('isLoggedIn');
        const user = JSON.parse(localStorage.getItem('user'));

        if (isLoggedIn === 'true') {
            $('#authLinks').html(`
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="logout()">Déconnexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> ${user.username} </a>
                </li>
            `);
        } else {
            $('#authLinks').html(`
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connexion</a>
                </li>
            `);
        }

        loadOffres();
    });

    function logout() {
        $('#logoutModal').modal('show'); // Ouvrir le modal de confirmation de déconnexion
    }

    function confirmLogout() {
        // Effacer les informations de l'offre et rediriger vers la page voulu
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        window.location.href = 'index.php';
    }

    function loadOffres() {
        const apiUrl = 'routes/offreApi.php';
        $.ajax({
            url: apiUrl + '?action=getAllOffres',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                response.forEach(function(offre) {
                    // Créer un objet Date à partir de la chaîne de date
                    const dateObj = new Date(offre.created_at);
                    // Formatter la date selon le format souhaité
                    const formattedDate = `${('0' + dateObj.getDate()).slice(-2)}/${('0' + (dateObj.getMonth() + 1)).slice(-2)}/${dateObj.getFullYear()} ${('0' + dateObj.getHours()).slice(-2)}:${('0' + dateObj.getMinutes()).slice(-2)}:${('0' + dateObj.getSeconds()).slice(-2)}`;
                    $('#offreTableBody').append(`
                        <tr>
                            <td>${offre.titre}</td>
                            <td>${formattedDate}</td>
                            <td>${offre.description}</td>
                            <td>${offre.statut}</td>
                            <td>${offre.entreprise}</td>
                            <td>${offre.lieu}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editOffre(${offre.id}, '${echapperQuotes(offre.titre)}', '${offre.created_at}', '${offre.url}', '${echapperQuotes(offre.description)}', '${echapperQuotes(offre.statut)}', '${echapperQuotes(offre.entreprise)}', '${echapperQuotes(offre.lieu)}', ${offre.user_id})">Modifier</button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete(${offre.id})">Supprimer</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des offres :', error);
            }
        });
    }

    function echapperQuotes(str) {
        return str.replace(/'/g, "\\'").replace(/"/g, '\\"');
    }

    $('#createOffreForm').on('submit', function(e) {
        e.preventDefault();
        createOffre();
    });

    function createOffre() {
        const titre = $('#createTitre').val();
        const url = $('#createUrl').val();
        const description = $('#createDescription').val();
        const statut = $('#createStatut').val();
        const entreprise = $('#createEntreprise').val();
        const lieu = $('#createLieu').val();
        const userId = $('#createUserId').val();

        $.ajax({
            url: 'routes/offreApi.php?action=createOffre',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                titre: titre,
                url: url,
                description: description,
                statut: statut,
                entreprise: entreprise,
                lieu: lieu,
                user_id: userId
            }),
            success: function(data) {
                // console.log(data);
                $('#createOffreForm')[0].reset();
                $('#createOffreModal').modal('hide');
                $('#message')
                .text('Une offre a été créée avec succès!')
                .addClass('alert alert-success');
                // Recharger la page après l'action réussie
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(error) {
                console.error('Erreur lors de la création de l\'offre :', error);
            }
        });
    }

    $('#editOffreForm').on('submit', function(e) {
        e.preventDefault();
        updateOffre();
    });

    // Formatage de la date
    function formatDateToInput(dateString) {
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');

        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    function editOffre(id, titre, created_at, url, description, statut, entreprise, lieu, user_id) {
        $('#editOffreId').val(id);
        $('#editTitre').val(titre);
        $('#editCreatedAt').val(formatDateToInput(created_at));
        $('#editUrl').val(url);
        $('#editDescription').val(description);
        $('#editStatut').val(statut);
        $('#editEntreprise').val(entreprise);
        $('#editLieu').val(lieu);
        $('#editUserId').val(user_id);
        $('#editOffreModal').modal('show');
    }

    function updateOffre() {
        const offreId = $('#editOffreId').val();
        const titre = $('#editTitre').val();
        const offreUrl = $('#editUrl').val();
        const created_at = $('#editCreatedAt').val();
        const description = $('#editDescription').val();
        const statut = $('#editStatut').val();
        const entreprise = $('#editEntreprise').val();
        const lieu = $('#editLieu').val();
        const userId = $('#editUserId').val();
        // console.log(created_at);
        $.ajax({
            url: `routes/offreApi.php?action=updateOffre&id=${offreId}`,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                id: offreId,
                titre: titre,
                created_at: created_at,
                url: offreUrl,
                description: description,
                statut: statut,
                entreprise: entreprise,
                lieu: lieu,
                user_id: userId
            }),
            success: function(response) {
                // console.log(response);
                $('#editOffreForm')[0].reset();
                $('#editOffreModal').modal('hide');
                $('#message')
                .text('Modification réussie avec succès!')
                .addClass('alert alert-success');
                // Recharger la page après l'action réussie
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la mise à jour de l\'offre :', error);
            }
        });
    }

    // Fonction pour afficher le modal de confirmation de suppression
    function confirmDelete(id) {
        // Assurez-vous que l'ID de l'offre est stocké dans le modal pour référence future
        $('#confirmDeleteButton').attr('data-offer-id', id);
        
        // Affichez le modal de confirmation
        $('#confirmDeleteModal').modal('show');
    }

    // Lorsque l'utilisateur confirme la suppression, exécutez la suppression via AJAX
    $('#confirmDeleteButton').on('click', function() {
        // Récupérer l'ID de l'offre à supprimer depuis le modal
        const offerId = $(this).attr('data-offer-id');

        // Effectuer la suppression via AJAX
        $.ajax({
            url: `routes/offreApi.php?action=deleteOffre&id=${offerId}`,
            type: 'DELETE',
            success: function(response) {
                // Actualiser la page après la suppression réussie
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la suppression de l\'offre :', error);
            }
        });

        // Cacher le modal de confirmation
        $('#confirmDeleteModal').modal('hide');
    });

    /* function deleteOffre(id) {
        if (confirm('Voulez-vous vraiment supprimer cette offre ?')) {
            $.ajax({
                url: `routes/offreApi.php?action=deleteOffre&id=${id}`,
                type: 'DELETE',
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la suppression de l\'offre :', error);
                }
            });
        }
    } */
</script>
</body>
</html>
