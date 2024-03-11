// Cette fonction écoute les changements sur la sélection de la date d'échéance
document.getElementById('due_date_select').addEventListener('change', function () {
    // Récupérer l'élément input pour la date personnalisée
    var customDateInput = document.getElementById('custom_due_date');

    // Vérifier si l'option choisie est "Choisir une date"
    if (this.value === 'choose_date') {
        // Si oui, changer le type de l'input en 'date' pour afficher le sélecteur de date natif du navigateur
        customDateInput.setAttribute('type', 'date');
        // Afficher l'input pour la date personnalisée
        customDateInput.style.display = 'block';
        // Mettre le focus sur l'input pour la date personnalisée
        customDateInput.focus();
    } else {
        // Si une autre option est sélectionnée, cacher l'input pour la date personnalisée
        customDateInput.setAttribute('type', 'text');
        customDateInput.style.display = 'none';
    }
});


// // Lorsque le formulaire de connexion est soumis
// document.getElementById('loginForm').addEventListener('submit', function (event) {
//     // Récupérer les valeurs des champs d'identification et de mot de passe
//     var identifierValue = document.getElementById('identifier').value.trim();
//     var passwordValue = document.getElementById('password').value.trim();

//     // Vérifier si les champs sont vides
//     if (identifierValue === '' || passwordValue === '') {
//         // Afficher un message d'erreur
//         alert('Veuillez remplir tous les champs');
//         // Arrêter l'envoi du formulaire
//         event.preventDefault();
//     }
// });
