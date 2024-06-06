<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil></title>
    <!-- CSS only -->
    <link href="public/styleAccueil.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column h-100">

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
        <div class="container">
        <h1 class="text-center">Bienvenue dans l'administration</h1>
        <p><a href="offre.php">Gérer les offres</a></p>
        <p><a href="utilisateur.php">Gérer les utilisateurs</a></p>
        </div>
        <div class="text-center">
            <a href="/home.php" class="btn btn-primary">voir la liste des offres</a>
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">Mon site - Tous droits réservés &copy; 2024</span>
        </div>
    </footer>

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
</body>

</html>