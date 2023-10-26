<?php
$conn = mysqli_connect("localhost", "root", "", "oracalphp");
// Check connection
if (!$conn) {
    http_response_code(500); // Internal Server Error
    die("Connection failed: " . mysqli_connect_error());
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header('Content-Type: application/json; charset=utf-8');

// Check if it is a preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT dealTitle, dealUrl,dealImage,dealDescription,dealSubTitle FROM `deals`";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        http_response_code(500); // Internal Server Error
        exit(json_encode(['status' => 'false', 'message' => 'Database query failed: ' . mysqli_error($conn)]));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    if (empty($data)) {
        http_response_code(404); // Not Found
        exit(json_encode(['status' => 'false', 'message' => 'No data found.']));
    }

    http_response_code(200); // OK
    exit(json_encode(['status' => 'true', 'data' => $data]));
} else {
    http_response_code(405); // Method Not Allowed
    exit(json_encode(['status' => 'false', 'message' => 'Method not allowed.']));
}
?>
