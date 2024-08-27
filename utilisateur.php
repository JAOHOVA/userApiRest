<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
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

    <main class="flex-shrink-0">
        <div class="container mt-5">
            <!-- Message de confiramtion -->
            <div id="message" class="text-center" style="margin-top: 74px";></div>

            <h1 class="text-center" style="margin-top: 62px";>Liste des utilisateurs</h1>
            
            <!-- Bouton pour afficher le formulaire de création -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userFormModal" >Créer Utilisateur</button>

            <!-- Tableau pour afficher la liste des utilisateurs -->
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom d'utilisateur</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actif</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <!-- Les données des utilisateurs seront affichées ici -->
                </tbody>
            </table>
        </div>
    </main>    

    <!-- Modal de création -->
    <div class="modal fade" id="userFormModal" tabindex="-1" aria-labelledby="userFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userFormModalLabel">Créer Utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur:</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe:</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles:</label>
                            <!-- <input type="text" class="form-control" id="roles"> -->
                            <select class="form-control" id="roles" aria-label="Sélectionnez une option">
                                <option value="" disabled selected>Open this select menu</option>
                                <option value="ROLE_ADMIN">ROLE_ADMIN</option>
                                <option value="ROLE_USER">ROLE_USER</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="active" class="form-label">Actif:</label>
                            <input type="checkbox" class="form-check-input" id="active">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de mise à jour -->
    <div class="modal fade" id="userFormModalUpdate" tabindex="-1" aria-labelledby="userFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userFormModalLabel">Modifier Utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="idUserId">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur:</label>
                            <input type="text" class="form-control" id="sUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="sEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe:</label>
                            <input type="password" class="form-control" id="sPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles:</label>
                            <!-- <input type="text" class="form-control" id="sRoles"> -->
                            <select class="form-control" id="sRoles" aria-label="Sélectionnez une option">
                                <option value="" disabled selected>Click your choice</option>
                                <option value="ROLE_ADMIN">ROLE_ADMIN</option>
                                <option value="ROLE_USER">ROLE_USER</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sActif" class="form-label">Actif:</label>
                            <input type="checkbox" class="form-check-input" id="sActif">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" onclick="updateUser()">Enregistrer</button>
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
                        <i class="fas fa-exclamation-triangle fs-3"></i>
                    </span>
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès actif -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Modification d'actif réussie!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" role="alert">
                        Votre modification d'actif a été effectuée avec succès !
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Vérifier l'URL pour déterminer la page actuelle
        const currentPage = window.location.pathname.split('/').pop().split('.').shift();

        // Activer le lien de navigation approprié en fonction de la page actuelle
        $(`.nav-link[data-page="${currentPage}"]`).addClass('active');

        // Check if the user is logged in
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

    });
    // Fonction de déconnexion
    function logout() {
        $('#logoutModal').modal('show'); // Ouvrir le modal de confirmation de déconnexion
    }

    function confirmLogout() {
        // Effacer les informations de l'utilisateur et rediriger vers la page voulu
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        window.location.href = 'index.php';
    }
</script>
<script>
    // Au chargement de la page, afficher la liste des utilisateurs
    $(document).ready(function() {
        $.ajax({
            url: 'routes/userApi.php?action=getAllUsers',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // console.log('Liste des utilisateurs :', response);
                // Afficher les utilisateurs dans le tableau
                response.forEach(function(user) {
                    $('#userTableBody').append(`
                        <tr>
                            <td>${user.id}</td>
                            <td>
                                <a href="#" onclick="showUserDetails(${user.id})">${user.username}</a>
                            </td>
                            <td>${user.email}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="customSwitch${user.id}" ${user.actif ? 'checked' : ''} onclick="toggleUserActive(${user.id})">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showUpdateForm(${user.id}, '${user.username}', '${user.email}', '${user.password}', '${user.roles}', '${user.actif}')">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(${user.id})">Supprimer</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des utilisateurs :', error);
            }
        });
    });

    $(document).ready(function() {
        // Écouter l'événement submit du formulaire
        $('#userFormModal').on('submit', function(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du formulaire

            // Appeler la fonction createUser() lorsque le formulaire est soumis
            createUser();
        });
    });

    // Fonction pour rediriger vers une nouvelle page avec les détails de l'utilisateur
    function showUserDetails(userId) {
        // Rediriger vers une nouvelle page avec l'ID de l'utilisateur
        window.location.href = `user-details.php?userId=${userId}`;
    }

    // Fonction pour afficher le formulaire de mise à jour
    function showUpdateForm(userId, username, email, password, roles, actif) {
        // console.log(userId, username, email,  password, roles, actif);
        // Convertir 'actif' en booléen
        const isActive = actif === '1' || actif === 1 || actif === true;

        $('#idUserId').val(userId);
        $('#sUsername').val(username);
        $('#sEmail').val(email);
        $('#sPassword').val(password);
        $('#sRoles').val(roles);
        $('#sActif').prop('checked', isActive);
        $('#userFormModalUpdate').modal('show');
    }

    // Fonction pour créer un utilisateur
    function createUser(event) {
        // Validation côté client
        const username = $('#username').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const roles = $('#roles').val();
        const actif = $('#active').is(':checked') ? 1 : 0;

        // Validation de l'adresse e-mail avec une expression régulière
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!username || !email || !password) {
            console.error('Veuillez remplir tous les champs du formulaire.');
            return;
        }
        if (!emailRegex.test(email)) {
            console.error('Veuillez entrer une adresse e-mail valide.');
            return;
        }

        // Envoyer une requête POST à votre API pour créer un utilisateur
        $.ajax({
            url: 'routes/userApi.php?action=createUser',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: username,
                email: email,
                password: password,
                roles: roles,
                actif: actif ? 1 : 0
            }),
            success: function(data) {
                // console.log(data.message);
                // Réinitialiser le formulaire
                $('#username').val('');
                $('#email').val('');
                $('#password').val('');
                $('#roles').val('');
                $('#active').prop('checked', false);
                // Masquer la modal
                $('#userFormModal').modal('hide');
                $('#message')
                .text('Un utilisateur a été créé avec succès!')
                .addClass('alert alert-success');
                // Recharger la page après l'action réussie
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(error) {
                console.error('Erreur lors de la création de l\'utilisateur :', error);
            }
        });
    }

    // Fonction pour mettre à jour un utilisateur
    function updateUser() {
        const userId = $('#idUserId').val();
        const username = $('#sUsername').val();
        const email = $('#sEmail').val();
        const password = $('#sPassword').val();
        const roles = $('#sRoles').val();
        const actif = $('#sActif').is(':checked');
        // console.log(userId, username, email, password);

        // Validation de l'adresse e-mail avec une expression régulière
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!username || !email || !password) {
            console.error('Veuillez remplir tous les champs du formulaire.');
            return;
        }
        if (!emailRegex.test(email)) {
            console.error('Veuillez entrer une adresse e-mail valide.');
            return;
        }

        // Envoyer une requête PUT à votre API pour mettre à jour un utilisateur
        $.ajax({
            url: `routes/userApi.php?action=updateUser&id=${userId}`,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                username: username,
                email: email,
                password: password,
                roles: roles,
                actif: actif ? 1 : 0
            }),
            success: function(response) {
                console.log('Réponse de l\'API :', response);
                // Actualiser la liste des utilisateurs après la mise à jour
                // ...
                $('#userFormModalUpdate').modal('hide');
                $('#message')
                .text('Modification réussie avec succès!')
                .addClass('alert alert-success');
                // Recharger la page après l'action réussie
                setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la requête AJAX pour mettre à jour l\'utilisateur :', error);
            }
        });
    }

    // Fonction pour changer le statut actif/inactif d'un utilisateur
    function toggleUserActive(userId) {
        // Récupérer l'état actuel de l'utilisateur
        const isActive = $(`#customSwitch${userId}`).is(':checked');
        $.ajax({
            url: 'routes/userApi.php?action=updateUserActive&id=' + userId,
            type: 'PUT',
            data: JSON.stringify({ actif: isActive }),
            contentType: 'application/json',
            success: function(response) {
                // console.log('Statut de l\'utilisateur mis à jour avec succès :', response);
                // Afficher le modal de succès
                $('#successModal').modal('show');
                // Fermer le modal après 2 secondes
                setTimeout(function() {
                    $('#successModal').modal('hide');
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la mise à jour du statut de l\'utilisateur :', error);
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
            url: `routes/offreApi.php?action=deleteUser&id=${offerId}`,
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

</script>

</body>
</html>
