<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Login and Signup</title>
    <!-- Lien vers le fichier CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/style.css">
</head>
<body class="bg-light">

    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Accueil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="btn btn-link nav-link" onclick="showCard('loginCard')">Connexion</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-link nav-link" onclick="showCard('signupCard')">S'inscrire</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

      <!-- Carte de connexion -->
    <div class="card-container" id="loginCard">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Connexion</h5>
            </div>
            <div class="card-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="loginEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="loginPassword" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Me connecter</button>
                    </div>
                </form>
                <div id="loginError" class="alert alert-danger mt-3 d-none"></div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn-close btn-close-bottom-left" aria-label="Close" onclick="hideCard('loginCard')"></button>
            </div>
        </div>
    </div>

    <!-- Carte d'inscription -->
    <div class="card-container" id="signupCard">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Inscription</h5>
                <button type="button" class="btn-close" aria-label="Close" onclick="hideCard('signupCard')"></button>
            </div>
            <div class="card-body">
                <form id="signupForm">
                    <div class="mb-3">
                        <label for="signupUsername" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="signupUsername" required>
                    </div>
                    <div class="mb-3">
                        <label for="signupEmail" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="signupEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="signupPassword" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="signupPassword" required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">M'inscrire</button>
                    </div>
                </form>
                <div id="signupError" class="alert alert-danger mt-3 d-none"></div>
            </div>
        </div>
    </div>

    <!-- Lien vers le fichier JavaScript de Bootstrap 5 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Lien vers jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showCard(cardId) {
            $('#' + cardId).fadeIn();
        }

        function hideCard(cardId) {
            $('#' + cardId).fadeOut();
        }

        $(document).ready(function() {
            // Gestion de la connexion
            $('#loginForm').on('submit', function(event) {
                event.preventDefault();
                const email = $('#loginEmail').val();
                const password = $('#loginPassword').val();
                $.ajax({
                    url: 'routes/userApi.php?action=login',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ email: email, password: password }),
                    success: function(response) {
                        if (response.error) {
                            $('#loginError').text(response.error).removeClass('d-none');
                        } else {
                            localStorage.setItem('token', response.token);
                            window.location.href = 'accueil.php';
                        }
                    },
                    error: function() {
                        $('#loginError').text('An error occurred. Please try again.').removeClass('d-none');
                    }
                });
            });

            // Gestion de l'inscription
            $('#signupForm').on('submit', function(event) {
                event.preventDefault();
                const username = $('#signupUsername').val();
                const email = $('#signupEmail').val();
                const password = $('#signupPassword').val();
                $.ajax({
                    url: 'routes/userApi.php?action=createUser', // Remplacez par le chemin vers votre API d'inscription
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ username: username, email: email, password: password, roles: 'user', actif: 1 }),
                    success: function(response) {
                        if (response.error) {
                            $('#signupError').text(response.error).removeClass('d-none');
                        } else {
                            hideCard('signupCard');
                            alert('Inscription réussie! Vous pouvez maintenant vous connecter.');
                        }
                    },
                    error: function() {
                        $('#signupError').text('An error occurred. Please try again.').removeClass('d-none');
                    }
                });
            });
        });
    </script>
</body>
</html>
