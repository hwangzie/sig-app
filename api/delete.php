<?php
/**
 * Delete GIS Data
 * Sistem Informasi Geospatial - API Endpoint
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once '../config/database.php';

try {
    // Validasi method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST method allowed");
    }

    // Validasi input
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception("ID is required");
    }

    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        throw new Exception("Invalid ID format");
    }

    $db = new Database();
    $conn = $db->getConnection();

    // Gunakan prepared statement untuk keamanan
    $sql = "DELETE FROM gis_data WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(array("status" => "success", "message" => "Data deleted successfully"));
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