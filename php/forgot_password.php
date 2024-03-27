<?php
/*
session_start();
require_once 'connection_database.php';
*/
?>

<!-- <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Mot de passe oublié</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="/css/style_forms.css" />
    </head>

    <body>
        <section class="form-02-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="_lk_de">
                            <div class="form-03-main">
                                <h1>Réinitialiser le mot de passe</h1>
                                <?php
                                // // Afficher les messages d'erreur ou de succès ici
                                // if (isset ($_SESSION['error'])) {
                                //     echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                                //     unset($_SESSION['error']); // Supprimer le message d'erreur après l'avoir affiché une fois
                                // }
                                ?>
                                <form action="forgot_password_processing.php" method="post">
                                    <div class="form-group">
                                        <label for="email">Entrez votre adresse e-mail :</label>
                                        <input class="form-control check-input" type="email" id="email" name="email"
                                            required>
                                    </div>
                                    <div class="button-group">

                                        <button type='submit' class='btn btn-primary btn-lg'>Envoyer</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="../js/script.js"></script>
    </body>

    </html> -->