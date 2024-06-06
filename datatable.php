<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/style.css" rel="stylesheet">
    <title><?php echo $title; ?></title>

<!--    <title>Document</title>-->
</head>
<body class="d-flex flex-column h-100">

    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/home.php">Mes missions</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo !empty($index)?"active":"" ?>" aria-current="page" href="/">Accueil</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) : ?>
                            <?php if (isset($_SESSION['user']['roles']) && $_SESSION["user"]["roles"] === '["ROLE_ADMIN"]') : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="views/admin/index.php">Admin</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="views/admin/profil.php">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="views/admin/deconnexion.php">Déconnexion</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/views/admin/connexion.php">Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </nav>
    </header>

    <main class="flex-shrink-0">
        <div class="container">

            <?php if (!empty($_SESSION['error'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['message'])) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['message'];
                    unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            <?php echo $content; ?>

<!--            <h1 class="text-center mb-3">Liste des missions associée avec les différentes tables</h1>-->
<!--            <table id="table_id" class="display" style="width:100%">-->
<!--                <thead>-->
<!--                    <tr>-->
<!--                        <th>Title </th>-->
<!--                        <th>Status</th>-->
<!--                        <th>Country</th>-->
<!--                        <th>MissionType</th>-->
<!--    -->
<!--                    </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                    <tr>-->
<!--                        <td><a href="#">Liquidation des opposants</a></td>-->
<!--                        <td>En préparation</td>-->
<!--                        <td>Slovenie</td>-->
<!--                        <td>Elimination</td>-->
<!--    -->
<!--                    <tr>-->
<!--                        <td>Elimination des mercenaires</td>-->
<!--                        <td>en cours</td>-->
<!--                        <td>Afganistan</td>-->
<!--                        <td>Elimination</td>-->
<!--    -->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>Surveillance de territoire</td>-->
<!--                        <td>en cours</td>-->
<!--                        <td>Nairobi</td>-->
<!--                        <td>Surveillance</td>-->
<!--    -->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>Infiltration de l'école d’administration</td>-->
<!--                        <td>échec</td>-->
<!--                        <td>France</td>-->
<!--                        <td>Infiltration</td>-->
<!--    -->
<!--                    </tr>-->
<!--                </tbody>-->
<!--            </table>-->
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">Mon kgb - Tous droits réservés &copy; 2023</span>
        </div>
    </footer>

    <script type="text/javascript" src="../public/js/script.js"></script>
    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
</body>
</html>