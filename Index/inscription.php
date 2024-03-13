<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page d'inscription </title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- Bootstrap icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/style/style_forms.css" />
</head>

<body>
    <?php
    // Afficher le message d'erreur s'il existe
    if (isset($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
    ?>
    <section class="form-02-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="_lk_de">
                        <div class="form-03-main">
                            <?php
                            // Afficher les erreurs s'il y en a
                            if (isset($_SESSION['error'])) {
                                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                                unset($_SESSION['error']); // Supprimer l'erreur de la session pour qu'elle ne s'affiche qu'une fois
                            }
                            ?>
                            <div class="logo">
                                <img src="/Images/user.png" alt="User logo">
                            </div>
                            <form id="inscriptionForm" method="POST" action="inscription_traitement.php">
                                <div class="form-group">
                                    <label for="first_name">Prénom: </label>
                                    <input type="text" id="first_name" name="first_name" class="form-control"
                                        placeholder="Entrez votre prénom..." required />
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Nom: </label>
                                    <input type="text" id="last_name" name="last_name" class="form-control"
                                        placeholder="Entrez votre nom..." required />
                                </div>
                                <div class="form-group">
                                    <label for="username">Nom utilisateur: </label>
                                    <input type="text" id="username" name="username" class="form-control"
                                        placeholder="Entrez votre nom d'utilisateur..." required />
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail: </label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Entrez votre e-mail..." required />
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe: </label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Entrez votre mot de passe..." required />
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirmation de mot de passe:</label>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="form-control" placeholder="Confirmez votre mot de passe..." required />
                                </div>

                                <div class="checkbox form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember">
                                        <label class="form-check-label remember-label" for="remember">Se Rappeler de
                                            moi</label>
                                    </div>
                                </div>

                                <div class="button-group_inscription">
                                    <button type="submit" class="btn btn-success btn-lg">Créer un nouveau
                                        compte</button>
                                    <br>
                                    <button onclick="window.location.href ='./connexion.php' " type="button"
                                        class="btn btn-info btn-lg">Se
                                        connecter</button>


                                </div>
                            </form>
                            <div class="form-group nm_lk">
                                <p class="h4">Ou se connecter avec:</p>
                            </div>
                            <div class="form-group pt-0">
                                <div class="_social_04">
                                    <ol>
                                        <li><i class="fab fa-github"></i></li>
                                        <li><i class="fab fa-twitter"></i></li>
                                        <li><i class="fab fa-google-plus-g"></i></li>
                                        <li><i class="fab fa-instagram"></i></li>
                                        <li><i class="fab fa-linkedin"></i></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <script src="/script/script.js"></script>
</body>

</html>