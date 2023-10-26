<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "oracalphp";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set headers for CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header('Content-Type: application/json; charset=utf-8');

// Check if it is a preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query = "SELECT maincategorytitle FROM maincategory"; // Corrected the query syntax

    $result = $conn->query($query);

    if ($result) {
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode(['status' => 'true', 'response' => $data]); // Return the data as JSON
    } else {
        echo json_encode(['status' => 'false', 'message' => 'Failed to fetch data: ' . $conn->error]);
    }

    $conn->close(); // Close the database connection
} else {
    echo json_encode(['status' => 'false', 'message' => 'Invalid Request']);
}
