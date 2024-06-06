<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <div class="container-fluid register-container">
        <div class="register-card bg-light">
            <h4 class="text-center mb-4">Inscription</h4>
            <form id="registerForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" placeholder="Entrez votre nom d'utilisateur" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" id="email" placeholder="Entrez votre email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
                </div>
                <div id="message" class="mt-3"></div>
            </form>
        </div>
    </div>

    <!-- Modal de succès d'inscription -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Inscription réussie!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" role="alert">
                        Félicitations ! Votre inscription a été effectuée avec succès.
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(event) {
                event.preventDefault();

                var username = $('#username').val();
                var email = $('#email').val();
                var password = $('#password').val();
                const actif = 0;
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
                // console.log(username, email, password);
                $.ajax({
                    url: 'routes/userApi.php?action=createUser',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        username: username,
                        email: email,
                        password: password,
                        // roles: 'ROLE_USER',  // Default role
                        actif: actif      // Default active status
                    }),
                    success: function(response) {
                        // console.log(response);
                        /* $('#message')
                        .text('Inscription réussie!')
                        .addClass('alert alert-success'); */
                        // Afficher le modal de succès
                        $('#successModal').modal('show');
                        // Temporisation de 3 secondes avant de rediriger l'utilisateur
                        setTimeout(function() {
                            window.location.href = '/Connexion.php';
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        $('#message').text('Erreur lors de l\'inscription. Veuillez réessayer.').addClass('alert alert-danger');
                    }
                });
            });
        });
    </script>
</body>
</html>
