<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page de Connexion</title>
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
                                // Supprimer l'erreur de la session pour qu'elle ne s'affiche qu'une fois
                                unset($_SESSION['error']);
                            }
                            ?>

                            <div class="logo">
                                <img src="/Images/user.png" alt="User logo">
                            </div>
                            <form id="login_Form" method="POST" action="connexion_traitement.php">
                                <!-- Assurez-vous que le formulaire pointe vers la bonne page PHP -->
                                <div class="form-group">
                                    <label for="identifier">nom d'utilisateur ou e-mail : </label>
                                    <input type="text" id="identifier" name="identifier" class="form-control"
                                        placeholder="nom d'utilisateur ou e-mail..." required />
                                </div>
                                <div class="form-group">
                                    <label for="password">mot de passe :</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Entrez votre mot de passe..." required>
                                </div>
                                <div class="checkbox form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember">
                                        <label class="form-check-label remember-label" for="remember">Se
                                            Rappeler de moi</label>
                                    </div>
                                    <label for="password" class="password">Mot de passe oublié</label>
                                </div>
                                <div class="button-group">
                                    <button type="submit" class="btn btn-warning btn-lg">Connexion</button>
                                    <a href="inscription.php" class="btn btn-primary btn-lg enable" role="button">Créer
                                        un compte</a>

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
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="/script/script.js"></script>
</body>

</html>