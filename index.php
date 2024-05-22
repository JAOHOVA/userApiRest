<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Utilisateurs</h2>
    
    <!-- Bouton pour afficher le formulaire de création -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userFormModal" >Créer Utilisateur</button>

    <!-- Tableau pour afficher la liste des utilisateurs -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
            <!-- Les données des utilisateurs seront affichées ici -->
        </tbody>
    </table>
</div>

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
                        <input type="text" class="form-control" id="roles">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" onclick="createUser()">Enregistrer</button>
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
                        <input type="text" class="form-control" id="sRoles">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="updateUser()">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet utilisateur ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" onclick="deleteUser()">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Au chargement de la page, afficher la liste des utilisateurs
    $(document).ready(function() {
        $.ajax({
            url: 'routes/api.php?action=getAllUsers',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Liste des utilisateurs :', response);
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
                                <button class="btn btn-warning btn-sm" onclick="showUpdateForm(${user.id}, '${user.username}', '${user.email}', '${user.password}', '${user.roles}')">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Supprimer</button>
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

    // Fonction pour rediriger vers une nouvelle page avec les détails de l'utilisateur
    function showUserDetails(userId) {
        // Rediriger vers une nouvelle page avec l'ID de l'utilisateur
        window.location.href = `user-details.html?userId=${userId}`;
    }

    // Fonction pour afficher le formulaire de création
    // FIXME : 
    function showCreateForm() {
        $('#userId').val('');
        $('#username').val('');
        $('#email').val('');
        $('#password').val('');
        $('#sRoles').val('');
        $('#userFormModal').modal('show');
    }

    // Fonction pour afficher le formulaire de mise à jour
    function showUpdateForm(userId, username, email, password, roles) {
        // console.log(userId, username, email);
        $('#idUserId').val(userId);
        $('#sUsername').val(username);
        $('#sEmail').val(email);
        $('#sPassword').val(password);
        $('#sRoles').val(roles);
        $('#userFormModalUpdate').modal('show');
    }

    // Fonction pour demander confirmation avant de supprimer un utilisateur
    function confirmDeleteUser(userId) {
        // Fermer la modal de confirmation
        $('#confirmDeleteModal').modal('show');

        // Appeler la fonction deleteUser avec l'ID de l'utilisateur
        // deleteUser(userId);
    }

    // Fonction pour créer un utilisateur
    function createUser() {
        // Validation côté client
        const username = $('#username').val();
        const email = $('#email').val();
        const password = $('#password').val();

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
            url: 'routes/api.php?action=createUser',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: username,
                email: email,
                password: password
            }),
            success: function(data) {
                console.log(data.message);
                // Après la création, actualiser la liste des utilisateurs
                // showUserList();

                // Réinitialiser le formulaire
                $('#username').val('');
                $('#email').val('');
                $('#password').val('');

                // Masquer la modal
                $('#userFormModal').modal('hide');

                // Recharger la page après l'action réussie
                // location.reload();
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
            url: `routes/api.php?action=updateUser&id=${userId}`,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                username: username,
                email: email,
                password: password
            }),
            success: function(response) {
                console.log('Réponse de l\'API :', response);
                // Actualiser la liste des utilisateurs après la mise à jour
                // ...
                $('#userFormModalUpdate').modal('hide');
                // Recharger la page après l'action réussie
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la requête AJAX pour mettre à jour l\'utilisateur :', error);
            }
        });
    }

    // Fonction pour supprimer un utilisateur
    function deleteUser(userId) {
        // Utiliser la fonction confirm() pour afficher une alerte de confirmation
        const userConfirmed = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");

        // Vérifier si l'utilisateur a confirmé
        if (userConfirmed) {
            // Si confirmé, envoyer la requête DELETE à votre API pour supprimer l'utilisateur avec l'ID donné
            $.ajax({
                url: `routes/api.php?action=deleteUser&id=${userId}`,
                type: 'DELETE',
                dataType: 'json',
                contentType: 'application/json',
                success: function(response) {
                    console.log('Réponse de l\'API lors de la suppression :', response);
                    // Actualiser la liste des utilisateurs après la suppression
                    // ...

                    // Recharger la page après l'action réussie
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la requête AJAX pour supprimer l\'utilisateur :', error);
                }
            });
        }
    }

</script>

</body>
</html>
