document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez tous les champs de type file
    var fileInputs = document.querySelectorAll('input[type="file"]');

    // Pour chaque champ de type file
    fileInputs.forEach(function(input) {
        // Ajoutez un gestionnaire d'événements change
        input.addEventListener('change', function() {
            // Lisez l'image sélectionnée
            var file = this.files[0];
            var reader = new FileReader();

            reader.addEventListener('load', function() {
                // Mettre à jour la source de l'élément img correspondant
                var id = input.id;
                var imgElement = document.getElementById(id + '-preview');
                imgElement.src = reader.result;
            });
            reader.readAsDataURL(file);
        });
    });
});