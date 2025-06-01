<?php
/**
 * Get GIS Data API
 * Sistem Informasi Geospatial - API Endpoint
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    $sql = "SELECT id, name, type, geometry, area, created_at FROM gis_data ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $features = array();
    while ($row = $result->fetch_assoc()) {
        $feature = array(
            "type" => "Feature",
            "geometry" => json_decode($row['geometry']),
            "properties" => array(
                "id" => (int)$row['id'],
                "name" => $row['name'],
                "type" => $row['type'],
                "area" => $row['area'],
                "created_at" => $row['created_at']
            )
        );
        $features[] = $feature;
    }
    
    $geojson = array(
        "type" => "FeatureCollection",
        "features" => $features
    );
    
    echo json_encode($geojson);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("error" => $e->getMessage()));
} finally {
    if (isset($db)) {
        $db->close();
    }
}
?>