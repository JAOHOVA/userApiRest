<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .search-bar {
      margin-bottom: 20px;
    }
  </style>
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
</div>

<footer class="footer mt-auto py-3 bg-light text-center">
    <div class="container">
        <span class="text-muted">Mon site - Tous droits réservés &copy; 2024</span>
    </div>
</footer>
<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Lien vers jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fonction pour récupérer les données des offres
    function fetchOffres() {
        $.ajax({
            url: 'routes/offreApi.php?action=getAllOffres',
            method: 'GET',
            success: function(data) {
                // console.log('Liste des offres :', data);
                displayOffres(data);
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des offres:', error);
            }
        });
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

    // Appeler la fonction fetchOffres au chargement de la page
    $(document).ready(function() {
        fetchOffres();
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


</body>
</html>
