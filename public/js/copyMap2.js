function initMap() {
    // On initialise la carte
      var carte = L.map('map').setView([43.529742, 5.447427], 13);
    
      // On charge les "tuiles"
      L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
      }).addTo(carte);
    
      // On initialise le groupe de marqueurs
      var marqueurs = L.markerClusterGroup();
      var tableauMarqueurs = [];
    
    //   Make an AJAX request to the PHP script that you created to retrieve the data
    //  from the database and encode it as a JSON object. You can use the fetch() 
    //  function for this
    
    // fetch('../../Controller/map.php')
    // .then(response => {
    //   return response.json();
    // })
    // .then(data => {
    //   for (place in places) {
    
    //     var markerUrl = 'public/img/markers/' + place.markerCategory;
    //     var markerIcon = L.icon({
    //       iconUrl: markerUrl,
    //       iconSize: [25, 41],
    //       iconAnchor: [12, 41],
    //       popupAnchor: [1, -34]
    //     });
    //     // var icone = L.icon({
    //     //   iconUrl: 'public/img/marker/' + data[place].marker,
    //     //   iconSize: [32, 32],
    //     //   iconAnchor: [16, 16]
    //     // });
    //     var marker = L.marker([place.latPlace, place.longPlace],{
    //       icon: markerIcon
    //     // var marqueur = L.marker([data[place].lat, data[place].lon], {
    //     //   icon: icone
    //     });
    //     marqueur.bindPopup('<h2><a href="http://">' + data[place].title + '</a></h2>');
    //     marqueurs.addLayer(marqueur);
    //     tableauMarqueurs.push(marqueur);
    //   }
    // });
    
    
    fetch('Controller/map.php')
      .then(response => response.json())
      .then(data => {
        var places = data;
        console.log(places);
        // Boucle sur chaque lieu
        places.forEach(place => {
          // Création du marqueur
          var marker = L.marker([place.longPlace, place.latPlace], {
            icon: L.icon({
              iconUrl: './../img/markers' + place.markerCategory, // Nom du fichier du marqueur
              iconSize: [25, 41],
              iconAnchor: [12, 41],
              popupAnchor: [1, -34],
              shadowSize: [41, 41]
            })
          });
          // Ajout du marqueur au cluster
          marqueurs.addLayer(marker);
          // Ajout du marqueur à la carte
          marker.addTo(map);
        });
      });
    
    
    
    
    
    // var groupe = new L.featureGroup(tableauMarqueurs);
    
    // carte.fitBounds(groupe.getBounds().pad(0.5));
    
    // carte.addLayer(marqueurs);
    }
      // Chargement de la carte lorsque la page est chargée
      document.addEventListener('DOMContentLoaded', initMap);