<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web GIS CRUD - Sistem Informasi Geospatial</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    
    <!-- Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        #map {
            height: 90vh;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .leaflet-popup-content {
            font-size: 14px;
        }
        .leaflet-popup button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .leaflet-popup button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h2>SIG CRUD dengan Leaflet</h2>
    <div id="map"></div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

    <script>
    var map = L.map('map').setView([0.0263, 109.3425], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // Helper function to calculate and format area
    function calculateArea(geojson) {
        if (!geojson || geojson.type !== 'Polygon') {
            return null;
        }
        
        // Calculate area using Turf.js
        var area = turf.area(turf.polygon(geojson.coordinates));
        
        // Format area for display
        if (area >= 1000000) {
            return (area / 1000000).toFixed(2) + ' km²';
        } else {
            return area.toFixed(2) + ' m²';
        }
    }

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        edit: { featureGroup: drawnItems },
        draw: {
            polygon: true,
            polyline: true,
            rectangle: false,
            circle: false,
            marker: true
        }
    });
    map.addControl(drawControl);

    map.on(L.Draw.Event.CREATED, function (e) {
        var layer = e.layer;
        drawnItems.addLayer(layer);
        
        // Prompt user for name and type information
        var name = prompt("Enter name for this feature:", "");
        var type = e.layerType;  // Get type from the event
        
        if (name) {
            // Create GeoJSON from the drawn layer
            var geojson = layer.toGeoJSON().geometry;
            
            // Calculate area for polygons
            var area = null;
            if (type === 'polygon') {
                area = calculateArea(geojson);
            }
            
            // Save to database via API
            fetch("api/save.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `name=${encodeURIComponent(name)}&type=${encodeURIComponent(type)}&geometry=${encodeURIComponent(JSON.stringify(geojson))}&area=${encodeURIComponent(area || '')}`
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    location.reload();
                } else {
                    alert("Failed to save: " + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Failed to save the data");
            });
        }
    });

    // Load existing data from database
    fetch("api/get_data.php")
        .then(res => res.json())
        .then(geojson => {
            L.geoJSON(geojson, {
                onEachFeature: function (feature, layer) {
                    let props = feature.properties;
                    
                    // Calculate area for polygons if not already provided
                    let areaInfo = '';
                    if (props.type === 'polygon') {
                        let area = props.area || calculateArea(feature.geometry);
                        if (area) {
                            areaInfo = `<br>Luas: ${area}`;
                        }
                    }
                    
                    layer.bindPopup(`
                        <b>${props.name}</b><br>
                        Tipe: ${props.type}${areaInfo}<br>
                        <button onclick="deleteData(${props.id})">Hapus</button>
                    `);
                    
                    // Store feature data on the layer for editing
                    layer.feature = feature;
                    
                    // Add each layer to drawnItems
                    drawnItems.addLayer(layer);
                }
            });
        });

    function deleteData(id) {
        if (confirm("Yakin ingin menghapus data ini?")) {
            fetch("api/delete.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    location.reload();
                } else {
                    alert("Failed to delete: " + result.message);
                }
            });
        }
    }
    </script>
</body>
</html>

