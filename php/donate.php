<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$host = "localhost";
$db = "st.stephen";
$user = "root";
$password = "";
$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Helper function to generate control number
function generateControlNumber($length = 8) {
    return strtoupper(bin2hex(random_bytes($length / 2)));
}

// Save donation data into the database
function saveDonation($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO donations (control_number, amount, name, email, phone, message, status, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sdssss", 
        $data['control_number'], 
        $data['amount'], 
        $data['name'], 
        $data['email'], 
        $data['phone'], 
        $data['message']
    );

    return $stmt->execute();
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Validate required fields
        if (empty($data['amount']) || empty($data['name']) || empty($data['email'])) {
            throw new Exception("Amount, Name, and Email are required");
        }

        // Generate and attach control number
        $controlNumber = generateControlNumber();
        $data['control_number'] = $controlNumber;

        // Save to DB
        if (!saveDonation($conn, $data)) {
            throw new Exception("Failed to save donation");
        }

        echo json_encode([
            "success" => true,
            "message" => "Donation recorded successfully",
            "control_number" => $controlNumber
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Only POST method is allowed"]);
}
