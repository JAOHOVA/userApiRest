<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<div class="container mt-5">
    <h2>Détails de l'utilisateur</h2>

    <div id="userDetails">
        <!-- Les détails de l'utilisateur seront affichés ici -->
    </div>

    <a href="javascript:history.back()" class="btn btn-secondary mt-3">Retour</a>
</div>

<footer class="footer mt-auto py-3 bg-light text-center">
    <div class="container">
        <span class="text-muted">Mon site - Tous droits réservés &copy; 2024</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fonction pour extraire les paramètres de requête de l'URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Fonction pour charger les détails de l'utilisateur
    function loadUserDetails() {
        // Récupérer l'ID de l'utilisateur à partir des paramètres de requête
        const userId = getQueryParam('userId');

        // Vérifier si l'ID de l'utilisateur est présent
        if (userId) {
            // Envoyer une requête AJAX pour obtenir les détails de l'utilisateur
            $.ajax({
                url: `routes/userApi.php?action=getUserById&id=${userId}`,
                type: 'GET',
                dataType: 'json',
                success: function(userDetails) {
                    // Déterminer le statut actif de l'utilisateur
                    const actifStatus = userDetails.actif ? 'Actif' : 'Inactif';

                    // Afficher les détails de l'utilisateur sur la page
                    $('#userDetails').html(`
                        <p><strong>ID:</strong> ${userDetails.id}</p>
                        <p><strong>Nom d'utilisateur:</strong> ${userDetails.username}</p>
                        <p><strong>Email:</strong> ${userDetails.email}</p>
                        <p><strong>Statut:</strong> ${actifStatus}</p>
                        <!-- Ajoutez d'autres détails de l'utilisateur ici -->
                    `);
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la requête AJAX pour obtenir les détails de l\'utilisateur :', error);
                }
            });
        } else {
            // Si l'ID de l'utilisateur n'est pas présent, afficher un message d'erreur
            $('#userDetails').html('<p>Erreur : ID de l\'utilisateur non spécifié.</p>');
        }
    }

    // Appeler la fonction pour charger les détails de l'utilisateur au chargement de la page
    $(document).ready(function() {
        loadUserDetails();
    });
</script>
</body>
</html>
