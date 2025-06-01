<?php
/**
 * Save GIS Data API
 * Sistem Informasi Geospatial - API Endpoint
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once '../config/database.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST method allowed");
    }

    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['type']) || empty($_POST['geometry'])) {
        throw new Exception("Name, type, and geometry are required");
    }

    $name = trim($_POST['name']);
    $type = $_POST['type'];
    $geometry = $_POST['geometry'];
    $area = isset($_POST['area']) ? $_POST['area'] : null;

    // Validate geometry JSON
    $geometryData = json_decode($geometry);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid geometry JSON");
    }

    // Validate type
    $allowedTypes = ['polygon', 'polyline', 'marker'];
    if (!in_array($type, $allowedTypes)) {
        throw new Exception("Invalid type. Must be: " . implode(', ', $allowedTypes));
    }

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "INSERT INTO gis_data (name, type, geometry, area) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $type, $geometry, $area);
    
    if ($stmt->execute()) {
        $insertId = $conn->insert_id;
        echo json_encode(array(
            "status" => "success", 
            "message" => "Data saved successfully",
            "id" => $insertId
        ));
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("status" => "error", "message" => $e->getMessage()));
} finally {
    if (isset($db)) {
        $db->close();
    }
}
?>