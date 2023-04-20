function initMap() {

  let tableauMarqueurs = [];
  // Initialize the map
  let map = L.map('map').setView([43.529742, 5.447427], 13).setZoom(15);

  // Add a tile layer to the map
  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    minZoom: 1,
    maxZoom: 20
  }).addTo(map);

  let marqueurs = L.markerClusterGroup();

  let xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = () => {
    // La transaction est terminée ?
    if (xmlhttp.readyState == 4) {
      // Si la transaction est un succès
      if (xmlhttp.status == 200) {
        // On traite les données reçues
        let data = JSON.parse(xmlhttp.responseText)
        

        for (let i = 0; i < data.length; i++) {
          let marker = L.marker([data[i].latPlace
            , data[i].longPlace
          ], {
            icon: L.icon({
              iconUrl: 'public/img/markers/' + data[i].markerCategory,
              iconSize: [40, 60],
              iconAnchor: [20, 61],
              popupAnchor: [1, -61],
              shadowSize: [41, 41],
              className: 'cat' + data[i].idCategory
            })
          })
          // Add the marker to the map
          marker.addTo(map);

          marker.bindPopup('<div style="text-align:center"><h2><a class="popUpText" href="index.php?page=allUsers_onePlace&idPlace=' + data[i].idPlace + ' " target="_blank">' + data[i].titlePlace + '</a></h2> <img class="popUpImage" src=public/img/imagePlace/' + data[i].imagePlace + '> </div>');
          marqueurs.addLayer(marker); // On ajoute le marqueur au groupe

          // On ajoute le marqueur au tableau
          tableauMarqueurs.push(marker);
          // console.log(tableauMarqueurs);

          // Add the marker to the marker cluster group
           //markerClusterGroup.addLayer(tableauMarqueurs);
        }
        // On regroupe les marqueurs dans un groupe Leaflet
        let groupe = new L.featureGroup(tableauMarqueurs);
        // On adapte le zoom au groupe
        map.fitBounds(groupe.getBounds().pad(0.5));
        map.addLayer(marqueurs);
      } else {
        console.log(xmlhttp.statusText);
      }
    }
  }

  xmlhttp.open("GET", "Controller/markers.php");
  xmlhttp.send(null);

  // *************************************************************************************************
  //                                   GEOLOCALISATION DE L UTILISATEUR
  //************************************************************************************************ */

  // Récupère l'élément 
  let link = document.getElementById('geolocation-link');

  // Ajoute un gestionnaire d'événement click 
  link.addEventListener('click', function (event) {
    // Empêche le lien de rediriger vers une autre page
    event.preventDefault();

    // Vérifie l'état de la permission de géolocalisation
    navigator.permissions.query({ name: 'geolocation' }).then(function (permissionStatus) {
      // Si l'accès a déjà été accordé ou si l'utilisateur a choisi de toujours autoriser l'accès, appelle la fonction de géolocalisation
      if (permissionStatus.state === 'granted' || permissionStatus.state === 'prompt') {
        getUserLocation();
      } else {
        // Sinon, affiche un message à l'utilisateur
        alert('Vous devez autoriser l\'accès à votre position pour utiliser cette fonctionnalité.');
      }
    });
  });


  // Fonction de géolocalisation
  function getUserLocation() {
    // Identifiant de l'observateur de position
    var watcherId;
    watcherId = navigator.geolocation.watchPosition(
      // Fonction de callback en cas de succès
      function (position) {
        // Récupère les coordonnées de l'utilisateur
        let latUser = position.coords.latitude;
        // console.log(latUser);
        let lngUser = position.coords.longitude;
        // console.log(lngUser);
        // Ajoute un marqueur sur la carte à l'emplacement de l'utilisateur
        let markerUser = L.marker([latUser, lngUser]).addTo(map);
        markerUser.bindPopup('<div id="markerUser" style="text-align:center"><h2>Vous êtes ici</h2></div>');
        map.setView([latUser, lngUser]);
      },
      // Fonction de callback en cas d'échec
      function (error) {
        console.log('Geolocation failed: ' + error.message);
        // Affiche un message à l'utilisateur
        alert('La géolocalisation a échoué. Veuillez réessayer.');
      },
      // Options
      {
        maximumAge: 60000,
        timeout: 5000,
        enableHighAccuracy: true
      }
    );
  }


}

document.addEventListener('DOMContentLoaded', initMap);

const checkboxes = document.querySelectorAll('input[type=checkbox]');

checkboxes.forEach((checkbox) => {
  checkbox.addEventListener('change', () => {
    const categoryId = checkbox.id.slice(3);
    const elements = document.getElementsByClassName(`cat${categoryId}`);

    if (checkbox.checked) {

      for (let i = 0; i < elements.length; i++) {
        elements[i].style.opacity = '1';
      }
    } else {

      for (let i = 0; i < elements.length; i++) {
        elements[i].style.opacity = '0';
      }
    }
  });
});

