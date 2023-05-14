<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="Site web - Wikicats - Forum dédié aux chats" content="">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

        <link href="./src/styles/style.css" rel="stylesheet" type="text/css" />

        <title>
            <?= $title ?>
        </title>
    </head>

    <body>
        <div class="container">
            <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">

                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">

                    <li>
                        <a href="./accueil" class="nav-link px-2 link-secondary">Accueil</a>
                    </li>

                    <li>
                        <a href="./forum" class="nav-link px-2 link-dark">
                            <i class="fa-solid fa-cat"></i>
                            Forum
                        </a>
                    </li>

                </ul>

                <div class="col-md text-end">

                <?php if (isset($_SESSION) && !empty($_SESSION)) { ?>
                    
                <!-- If the user is connected -->

                <button type="button" class="btn-perso btn btn-outline-primary me-2">
                    <a href="./profil">Profil</a>
                </button>
                <button type="button" class="btn btn-danger">
                    <a href="./index.php?action=logout">Déconnexion</a>
                </button>

                <?php } else { ?>

                <!-- If the user is not connected -->

                <button type="button" class="btn btn-outline-primary me-2">
                    <a href="./connexion">Se connecter</a>    
                </button>
                <button type="button" class="btn btn-outline-primary">
                    <a href="./inscription">S'inscrire</a>    
                </button>

                <?php } ; ?>
                            
                </div>
            </header>
        </div>



        <div class="container">
            <?= $content; ?>
        </div>

        <div id="catLottie"></div>

    </body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/2fe7c14157.js" crossorigin="anonymous"></script>

    <!-- Ajout du chat qui suit le curseur -->
    <script src="https://cdn.jsdelivr.net/npm/lottie-web@5.7.9/build/player/lottie.js"></script>
    
    <script type="module" src="./src/index.js"></script>

</html>