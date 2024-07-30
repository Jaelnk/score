import 'ol/ol.css';
import {Map, View} from 'ol';
import {Tile as TileLayer} from 'ol/layer';
import {OSM, Vector as VectorSource} from 'ol/source';
import {fromLonLat, toLonLat} from 'ol/proj';
import Geolocation from 'ol/Geolocation';
import Feature from 'ol/Feature';
import Point from 'ol/geom/Point';
import {Vector as VectorLayer} from 'ol/layer';
import {Icon, Style} from 'ol/style';
import {Overlay} from 'ol';
import Select from 'ol/interaction/Select';
import {click} from 'ol/events/condition';

// Obtener los valores de los inputs
const latitudeInput = document.getElementById('latitude');
const longitudeInput = document.getElementById('longitude');

// Verificar si los inputs de latitud y longitud tienen valores
let initialCoordinates;
if (latitudeInput.value && longitudeInput.value) {
    initialCoordinates = fromLonLat([parseFloat(longitudeInput.value), parseFloat(latitudeInput.value)]);
} else {
    // Si no tienen valores, usar la ubicación por defecto (Cuenca)
    initialCoordinates = fromLonLat([-79.0143429, -2.893577399999998]);
}

// Configuración del mapa
const map = new Map({
    target: 'map',
    layers: [
        new TileLayer({
            source: new OSM()
        })
    ],
    view: new View({
        center: initialCoordinates,
        zoom: 15 // Establecer el zoom a 15
    })
});
map.getView().setZoom(15);

// Vector layer para el icono
const iconSource = new VectorSource();
const iconLayer = new VectorLayer({
    source: iconSource,
    style: new Style({
        image: new Icon({
            anchor: [0.5, 1],
            src: '/images/puntero.png', // Ruta al icono de posición
            scale: 0.01 // Escala del icono (ajusta según sea necesario)
        })
    })
});
// Estilo rojo para la ubicación adicional
const redIconStyle = new Style({
    image: new Icon({
        anchor: [0.5, 1],
        src: '/images/puntero_rojo.png', // Ruta al icono rojo de posición
        scale: 0.01 // Escala del icono (ajusta según sea necesario)
    })
});

map.addLayer(iconLayer);

// Crear overlay para los popups
const popupElement = document.createElement('div');
popupElement.className = 'ol-popup';
const popupContent = document.createElement('div');
popupElement.appendChild(popupContent);

const popup = new Overlay({
    element: popupElement,
    positioning: 'bottom-center',
    stopEvent: false,
    offset: [0, -50]
});
map.addOverlay(popup);

// Crear overlay para los popups adicionales
const additionalPopupElement = document.createElement('div');
additionalPopupElement.className = 'ol-popup';
const additionalPopupContent = document.createElement('div');
additionalPopupElement.appendChild(additionalPopupContent);

const additionalPopup = new Overlay({
    element: additionalPopupElement,
    positioning: 'bottom-center',
    stopEvent: false,
    offset: [0, -50]
});
map.addOverlay(additionalPopup);

// Función para actualizar la posición en el mapa
function updatePosition(lat, lon, text) {
    const position = fromLonLat([lon, lat]);
    map.getView().setCenter(position);

    const positionFeature = new Feature({
        geometry: new Point(position),
        name: text // Guardar el texto del popup en la propiedad del feature
    });
    iconSource.clear();
    iconSource.addFeature(positionFeature);

    // Mostrar popup en la ubicación
    popup.setPosition(position);
    popupContent.innerHTML = text;

    const additionalLatitude = parseFloat(document.getElementById('form_LatitudGPS').value);
    const additionalLongitude = parseFloat(document.getElementById('form_LongitudGPS').value);

    if (!isNaN(additionalLatitude) && !isNaN(additionalLongitude)) {
        const additionalCoordinates = fromLonLat([additionalLongitude, additionalLatitude]);

        const additionalFeature = new Feature({
            geometry: new Point(additionalCoordinates),
            name: 'Ubicación especificada adicional.' // Guardar el texto del popup adicional en la propiedad del feature
        });
        additionalFeature.setStyle(redIconStyle); // Aplicar estilo rojo

        iconSource.addFeature(additionalFeature);

        // Mostrar popup en la ubicación adicional
        additionalPopup.setPosition(additionalCoordinates);
        additionalPopupContent.innerHTML = 'Ubicación especificada adicional.';
    }
}

// Agregar interacción de selección para mostrar el popup
const select = new Select({
    condition: click,
    style: null // Usar el estilo ya definido en el VectorLayer
});
map.addInteraction(select);

select.on('select', function (event) {
    const selectedFeatures = event.target.getFeatures();
    selectedFeatures.forEach(function (feature) {
        const coordinates = toLonLat(feature.getGeometry().getCoordinates());
        popup.setPosition(fromLonLat(coordinates));
        popupContent.innerHTML = feature.get('name');
    });
});

// Obtener la ubicación actual del usuario
const geolocation = new Geolocation({
    tracking: true,
    projection: map.getView().getProjection()
});

geolocation.on('change:position', function () {
    const coordinates = geolocation.getPosition();
    const lonLat = toLonLat(coordinates);

    // Si los inputs están vacíos, usar la ubicación actual del usuario
    if (!latitudeInput.value || !longitudeInput.value) {
        latitudeInput.value = lonLat[1];
        longitudeInput.value = lonLat[0];
        updatePosition(lonLat[1], lonLat[0], 'Ubicación actual del usuario.');
    }

    // Detener el seguimiento de geolocalización
    geolocation.setTracking(false);
});

// Al cargar la página, verificar los valores de los inputs
window.addEventListener('load', function () {
    const lat = parseFloat(latitudeInput.value);
    const lon = parseFloat(longitudeInput.value);

    if (isNaN(lat) || isNaN(lon)) {
        // Si los valores no son válidos, usar la geolocalización del usuario
        geolocation.setTracking(true);
    } else {
        // Usar los valores de los inputs
        updatePosition(lat, lon, 'Ubicación especificada.');
    }

    // Obtener las coordenadas adicionales
    const additionalLatitude = parseFloat(document.getElementById('form_LatitudGPS').value);
    const additionalLongitude = parseFloat(document.getElementById('form_LongitudGPS').value);

    if (!isNaN(additionalLatitude) && !isNaN(additionalLongitude)) {
        const additionalCoordinates = fromLonLat([additionalLongitude, additionalLatitude]);

        const additionalFeature = new Feature({
            geometry: new Point(additionalCoordinates),
            name: 'Ubicación especificada adicional.' // Guardar el texto del popup adicional en la propiedad del feature
        });
        additionalFeature.setStyle(redIconStyle); // Aplicar estilo rojo

        iconSource.addFeature(additionalFeature);

        // Mostrar popup en la ubicación adicional
        additionalPopup.setPosition(additionalCoordinates);
        additionalPopupContent.innerHTML = 'Ubicación especificada adicional.';
    }
});

// Evento para buscar una dirección
document.getElementById('searchButton').addEventListener('click', function () {
    const searchText = document.getElementById('searchInput').value.trim();
    if (searchText !== '') {
        // Llamar al servicio de geocodificación (OpenCage Geocoder en este ejemplo)
        const apiKey = '949f6550fc3c44e4a330f9cded5d92d4'; // Reemplazar con tu API Key de OpenCage Geocoder
        const url = `https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(searchText)}&key=${apiKey}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.results && data.results.length > 0) {
                    const result = data.results[0];
                    const position = transform([result.geometry.lng, result.geometry.lat], 'EPSG:4326', 'EPSG:3857');
                    map.getView().setCenter(position);

                    // Añadir el icono en la posición encontrada
                    const positionFeature = new Feature({
                        geometry: new Point(position)
                    });
                    iconSource.clear();
                    iconSource.addFeature(positionFeature);
                } else {
                    alert('No se encontraron resultados para la dirección ingresada.');
                }
            })
            .catch(error => {
                console.error('Error al buscar la dirección:', error);
                alert('Ocurrió un error al buscar la dirección.');
            });
    } else {
        alert('Ingresa una dirección para buscar.');
    }
});

