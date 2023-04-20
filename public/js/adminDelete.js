// Sélection de tous les boutons de suppression
const deleteButtons = document.querySelectorAll('.delete-article-button');

// On parcours les boutons...
for (const button of deleteButtons) {

    // ... et on installe un gestionnaire d'événement au click sur chaque bouton 
    button.addEventListener('click', async function(event) {

        // Annulation du comportement par défaut du navigateur (envoyer l'internaute vers l'URL du lien)
        event.preventDefault();

        // Si l'internaute confirme la suppression
        if (window.confirm('Êtes-vous certain de vouloir supprimer cet lieu de visite?')) {
            
            // Désormais on va lancer une requête AJAX pour faire la suppression !

            // 1°) Récupérer l'URL à interroger en AJAX avec l'attribut data "ajax" de l'élément HTML cliqué.
            const urlAjax = event.currentTarget.dataset.ajax;

            // 2°) Lancer la requête AJAX avec fetch()
            // méthode fetch() pour lancer une requête AJAX vers l'URL récupérée. Cette méthode renvoie une promesse qui sera résolue lorsque la réponse de la requête AJAX sera reçue.
            const response = await fetch(urlAjax);
            // "await" pour attendre la résolution de la promesse avant de poursuivre l'exécution.
            const data = await response.json();
           

            // 3°) Lors de la réception de la réponse, on construit l'id de l'élément <tr> à supprimer et on le supprime
            // la méthode json() pour convertir la réponse en format JSON et stocke les données dans la variable "data". Ces données contiennent l'ID de l'article supprimé.
            const idTr = `place-${data.idPlace}`;
            
            document.getElementById(idTr).remove();
        }
    });
}