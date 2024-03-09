<?php require "connexion_database.php";
session_start() ?>
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
    <link rel="stylesheet" href="/styles/style.css" />
    <link rel="stylesheet" href="/style/Forms.css">

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
                            <div class="logo">
                                <img src="/Images/user.png" alt="User logo">
                            </div>
                            <form method="post" action="login.php">
                                <!-- Assurez-vous que le formulaire pointe vers la bonne page PHP -->
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Entrez votre email ou nom d'utilisateur..." required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Entrez votre mot de passe..." required>
                                </div>
                                <div class="checkbox form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember">
                                        <label class="form-check-label remember-label" for="remember">Se
                                            Rappeler de moi</label>
                                    </div>
                                    <a href="#">mot de passe oublié</a>
                                </div>

                                <div class="form-group">
                                    <div class="_btn_04">
                                        <a href="login.php">Connexion</a>
                                    </div>

                                    <p class="form-group inscription_1"> Pas encore de compte? <a href="./sign_up.php">
                                            S'inscrire</a>
                                    </p>
                                </div>
                            </form>
                            <div class="form-group nm_lk">
                                <p>Ou se connecter avec: </p>
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

    <?php
    echo $message_succes; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <script src="/Script/script.js"></script>
</body>

</html>