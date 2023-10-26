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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data['name'])) {
        $name = mysqli_real_escape_string($conn, $data['name']);

        $query = "INSERT INTO `maincategory` (maincategorytitle) VALUES ('$name')";

        if (mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'true', 'message' => 'Maincategory Saved Successfully']);
        } else {
            echo json_encode(['status' => 'false', 'message' => 'Failed Submission: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'false', 'message' => 'All Fields Are Required']);
    }
} else {
    echo json_encode(['status' => 'false', 'message' => 'Invalid Request Method']);
}
?>
