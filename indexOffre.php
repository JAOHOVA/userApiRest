<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Offres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclure Bootstrap 5 CSS -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des Offres</h1>
        <div id="offres-table"></div>
    </div>

    <!-- Inclure jQuery et Bootstrap 5 JS Bundle avec Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
