<?php
/**
 * Update GIS Data API
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
    if (empty($_POST['id']) || empty($_POST['name']) || empty($_POST['geometry'])) {
        throw new Exception("ID, name, and geometry are required");
    }

    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        throw new Exception("Invalid ID format");
    }

    $name = trim($_POST['name']);
    $geometry = $_POST['geometry'];
    $area = isset($_POST['area']) ? $_POST['area'] : null;

    // Validate geometry JSON
    $geometryData = json_decode($geometry);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid geometry JSON");
    }

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "UPDATE gis_data SET name=?, geometry=?, area=?, updated_at=CURRENT_TIMESTAMP WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssi", $name, $geometry, $area, $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(array("status" => "success", "message" => "Data updated successfully"));
        } else {
            echo json_encode(array("status" => "error", "message" => "No data found with that ID"));
        }
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
