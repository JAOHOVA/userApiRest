<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
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
    <div class="container-fluid login-container">
        <div class="login-card bg-light">
            <h4 class="text-center mb-4">Connexion</h4>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" id="email" placeholder="Entrez votre email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                </div>
                <p class="text-center mt-3">
                    Si vous n'êtes pas encore inscrit, <a href="inscription.php">cliquez ici</a>.
                </p>
            </form>
            <div id="loginError" class="alert alert-danger mt-3 d-none"></div>
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
            $('#loginForm').on('submit', function(event) {
                event.preventDefault();
                
                const email = $('#email').val();
                const password = $('#password').val();

                $.ajax({
                    url: 'routes/userApi.php?action=login',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ email: email, password: password }),
                    success: function(response) {
                        if (response.error) {
                            $('#loginError').text(response.error).removeClass('d-none');
                        } else {
                            localStorage.setItem('isLoggedIn', 'true');
                            localStorage.setItem('token', response.token);
                            localStorage.setItem('user', JSON.stringify(response.user)); // Stocker l'objet utilisateur
                            window.location.href = '/home.php';
                        }
                    },
                    error: function() {
                        $('#loginError').text('An error occurred. Please try again.').removeClass('d-none');
                    }
                });
            });
        });
    </script>
</body>
</html>
