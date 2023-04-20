// leaflet est une librairie qui fait abstraction de la carte que l on va utiliser on peut utiliser donc plusieurs 
//fournisseurs de cartes à la fois 
//on doit tout d abors charger le css et le js via cdn sur notre fichier phtml : se rendre sur https://leafletjs.com/examples/quick-start/
        
  var tableauMarqueurs = [];
  async function getPlaces() {
    try {
      const response = await fetch('map.php');
      if (response.ok) {
        const data = await response.json();
        console.log(data);
        data.forEach(place => {
          var marker = L.marker([place.latPlace, place.longPlace]).addTo(carte);
          marker.bindPopup(place.name);
        });
      } else {
        console.log(response.statusText);
      }
    } catch (error) {
      console.error(error);
    }
  }
  // On initialise la carte
  var carte = L.map('maCarte').setView([43.529742, 5.447427], 13);

  // On charge les "tuiles"
  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    // Il est toujours bien de laisser le lien vers la source des données de toute facon openstreet 
    //du moment que c est un service gratuit il demande dans tous les cas d afficher le copyrigth avec le lien internet
    //par défaut le damier de la map de openstreet map est assez chargé d infos
    //mais l on peut decider de changer de damier
    //il faut chercher les tuiles d openstreetmap 
    //un fois identifié le fournisseur de carte(damier) quel on souhaite, il faut en charger le script js
    //le lien il faut le mettre apres le script dela librairie leaflet parce qu'il injecte une nouvelle classe
    //dans l'objet L et si L n est pas chargé au préalable ca ne pourra pas marcher
    //et avant notre même js
    //Ensuit il faudra ahjouté au code map.addLayer(new L.StamenTileLayer('terrain'))
    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20
  }).addTo(carte);


  var marqueurs = L.markerClusterGroup();

  // On personnalise le marqueur
  var icone = L.icon({
    iconUrl: "img/markersAixplora - red.png",
    iconSize: [40, 60],
    iconAnchor: [25, 50],
    popupAnchor: [0, -50]
  })

  // On parcourt les différentes sites
  for (place in places) {
    // On crée le marqueur et on lui attribue une popup
    var marqueur = L.marker([places[place].lat, places[place].lon], {
      icon: icone
    }); //.addTo(carte); Inutile lors de l'utilisation des clusters
    marqueur.bindPopup('<h2><a href="http://">' + place + '</a></h2>');
    marqueurs.addLayer(marqueur); // On ajoute le marqueur au groupe

    // On ajoute le marqueur au tableau
    tableauMarqueurs.push(marqueur);
   
  }
  // On regroupe les marqueurs dans un groupe Leaflet
  var groupe = new L.featureGroup(tableauMarqueurs);

  // On adapte le zoom au groupe
  carte.fitBounds(groupe.getBounds().pad(0.5));

  carte.addLayer(marqueurs);


  