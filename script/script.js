// Cette fonction écoute les changements sur la sélection de la date d'échéance
document.getElementById('due_date_select').addEventListener('change', function () {
    // Récupérer l'élément input pour la date personnalisée
    let customDateInput = document.getElementById('custom_due_date');

    // Vérifier si l'option choisie est "Choisir une date"
    if (this.value === 'choose_date') {
        // Si oui, changer le type de l'input en 'date' pour afficher le sélecteur de date natif du navigateur
        customDateInput.setAttribute('type', 'date');
        // Afficher l'input pour la date personnalisée
        customDateInput.style.display = 'block';
        // Mettre le focus sur l'input pour la date personnalisée
        customDateInput.focus();
    } else {
        // Si une autre option est sélectionnée, cacher l'input pour la date personnalisée/
        customDateInput.setAttribute('type', 'text');
        customDateInput.style.display = 'none';
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const inscriptionForm = document.getElementById("inscriptionForm");
    inscriptionForm.addEventListener("submit", function (event) {
        // Récupérer les valeurs des champs
        let first_name = document.getElementById("first_name").value;
        let last_name = document.getElementById("last_name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let confirm_password = document.getElementById("confirm_password").value;

        // Vérifier si chaque champ est rempli
        switch (true) {
            case !first_name:
                alert("Vous devez saisir votre nom.");
                event.preventDefault();
                break;

            case !last_name:
                alert("Vous devez saisir votre prénom.");
                event.preventDefault();
                break;

            case !email:
                alert("Vous devez saisir votre adresse e-mail.");
                event.preventDefault();
                break;

            case !password:
                alert("Vous devez saisir un mot de passe.");
                event.preventDefault();
                break;

            default:
                if (password !== confirm_password) {
                    alert("Le mot de passe et la confirmation ne correspondent pas.");
                    event.preventDefault();
                } else {
                    // Si tout est bon, on envoie le formulaire
                    return true;
                }
        }

        // Vérifier si l'e-mail contient "@" et se termine par ".com"
        if (email.indexOf("@") === -1 || !email.endsWith(".com")) {
            alert("L'adresse e-mail doit contenir @ et se terminer par .com .");
            event.preventDefault();
            return;
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login_Form");
    loginForm.addEventListener("submit", function (event) {
        switch (true) {
            case identifier.length === 0:
                alert("Vous devez saisir votre adresse e-mail ou nom d'utilisateur.");
                event.preventDefault();
                break;
            case password.length === 0:
                alert("Vous devez saisir votre mot de passe.");
                event.preventDefault();
                break;
            default:
                // Si tout est bon, on envoie le formulaire
                return true;
        }
    });
});

