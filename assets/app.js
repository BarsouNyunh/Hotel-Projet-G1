/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

let macarte;
let zoom = 17; // 1-20
let marqueur;

/* L'API possède une fonction qui l'adresse à partir de coordonnées 
    https://nominatim.openstreetmap.org/reverse?lat=42&lon=128format=json
*/

navigator.geolocation.getCurrentPosition(function (infos) {

    console.log(infos);
    let lat = 48.865184;
    let lon = 2.303118;

    // L symbolise l'object leaflet
    macarte = L.map(document.getElementById('carte')).setView([lat,lon],zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png',{
        minZoom : 1,
        maxZoom : 20
    }).addTo(macarte);

    L.circle([lat,lon],{
        radius : 100
    }).addTo(macarte);

    marqueur = L.marker([lat,lon]).addTo(macarte).bindPopup('Nous sommes ici !').openPopup();

});
