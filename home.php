<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des offres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
    <!-- Barre de navigation -->
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/home.php">Mes offres</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Accueil</a>
                        </li>
                    </ul>
                    <form class="d-flex" id="searchForm" onsubmit="searchOffres(event)">
                        <input class="form-control me-2" type="search" id="searchInput" placeholder="Search" aria-label="Search">
                        <button class="btn btn-secondary" type="submit">Search</button>
                    </form>
                    <ul class="navbar-nav ml-auto" id="navbarNavLinks">
                        <!-- Les liens conditionnels seront insérés ici par jQuery -->
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

    <div class="container mt-5">
        <h1 class="mt-4">Liste des Offres</h1>
        <div id="offres-table">
            <!-- Liste des Offres -->
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Pagination Bootstrap sera insérée ici par JavaScript -->
            </ul>
        </nav>
    </div>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Lien vers jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fonction pour récupérer les données des offres avec pagination
        function fetchOffres(page, searchQuery = null) {
            // Récupérer d'abord le nombre total de pages
            $.ajax({
                url: 'routes/offreApi.php?action=getTotalPages&itemsPerPage=5',
                method: 'GET',
                success: function(data) {
                    var totalPages = data.total_pages;
                    // Une fois le nombre total de pages récupéré, récupérer les offres de la page spécifiée avec le terme de recherche
                    $.ajax({
                        url: 'routes/offreApi.php?action=getAllOffres&page=' + page + '&itemsPerPage=5' + (searchQuery ? '&search=' + searchQuery : ''),
                        method: 'GET',
                        success: function(data) {
                            displayOffres(data); // Afficher les offres
                            displayPagination(totalPages, page); // Afficher la pagination
                        },
                        error: function(error) {
                            console.error('Erreur lors de la récupération des offres:', error);
                        }
                    });
                },
                error: function(error) {
                    console.error('Erreur lors de la récupération du nombre total de pages:', error);
                }
            });
        }

        // Fonction pour rechercher les offres en fonction du terme de recherche
        function searchOffres(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du formulaire de soumission
            var searchQuery = $('#searchInput').val(); // Récupérer le terme de recherche depuis le champ de recherche
            fetchOffres(1, searchQuery); // Récupérer les offres correspondantes à partir de la première page
        }

        // Fonction pour afficher les données des offres dans une table
        function displayOffres(offres) {
            var table = '<table class="table table-striped table-bordered">';
            table += '<thead class="table-primary"><tr><th>Titre</th><th>Date de création</th><th>Description</th><th>Statut</th><th>Entreprise</th><th>Lieu</th></tr></thead>';
            table += '<tbody>';
            offres.forEach(function(offre) {
                table += '<tr>';
                table += '<td>' + offre.titre + '</td>';
                table += '<td>' + new Date(offre.created_at).toLocaleDateString() + '</td>';
                table += '<td>' + offre.description + '</td>';
                table += '<td>' + offre.statut + '</td>';
                table += '<td>' + offre.entreprise + '</td>';
                table += '<td>' + offre.lieu + '</td>';
                table += '</tr>';
            });
            table += '</tbody></table>';
            $('#offres-table').html(table);
        }

        // Fonction pour afficher la pagination
        function displayPagination(totalPages, currentPage) {
            var pagination = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
            pagination += '<li class="page-item ' + (currentPage == 1 ? 'disabled' : '') + '">';
            pagination += '<a class="page-link" href="#" onclick="fetchOffres(' + (currentPage - 1) + ')" tabindex="-1" aria-disabled="true">Précédent</a>';
            pagination += '</li>';

            for (var i = 1; i <= totalPages; i++) {
                pagination += '<li class="page-item ' + (i == currentPage ? 'active' : '') + '"><a class="page-link" href="#" onclick="fetchOffres(' + i + ')">' + i + '</a></li>';
            }

            pagination += '<li class="page-item ' + (currentPage == totalPages ? 'disabled' : '') + '">';
            pagination += '<a class="page-link" href="#" onclick="fetchOffres(' + (currentPage + 1) + ')">Suivant</a>';
            pagination += '</li></ul></nav>';

            $('#pagination').html(pagination);
        }

        // Appeler la fonction fetchOffres avec la pagination au chargement de la page
        $(document).ready(function() {
            fetchOffres(1); // Récupérer la première page des offres au chargement de la page
        });
    </script>
    <script>
        // Fonction pour mettre à jour le menu de navigation en fonction de l'état de l'utilisateur
        function updateNavbar() {
            const navbarNavLinks = $('#navbarNavLinks');
            const user = JSON.parse(localStorage.getItem('user'));

            // console.log(user);
            navbarNavLinks.empty(); // Vider le contenu existant

            if (user && user.id) {
                if (user.roles && user.roles.includes('ROLE_ADMIN')) {
                    navbarNavLinks.append('<li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>');
                }

                navbarNavLinks.append('<li class="nav-item"><a class="nav-link" href="#">' + user.username + '</a></li>');
                navbarNavLinks.append('<li class="nav-item"><a class="nav-link" href="#" onclick="logout()">Déconnexion</a></li>');
            } else {
                navbarNavLinks.append('<li class="nav-item"><a class="nav-link" href="Connexion.php">Connexion</a></li>');
            }
        }

        // Appeler la fonction updateNavbar au chargement de la page
        $(document).ready(updateNavbar);

        // Fonction de déconnexion
        /* function logout() {
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            window.location.href = 'index.php';
        } */
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
    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">Mon site - Tous droits réservés &copy; 2024</span>
        </div>
    </footer>
</body>
</html>
