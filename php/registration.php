<?php

require_once 'config.php';


// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $type = htmlspecialchars(trim($_POST['type']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format";
    }
    // Validate phone number format
    elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $errorMessage = "Invalid phone number format. Please enter digits only (10–15 digits).";
    }
    // Check required fields
    elseif (empty($full_name) || empty($email) || empty($phone) || empty($type)) {
        $errorMessage = "Please fill in all required fields.";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO registrations (full_name, email, phone, type, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $email, $phone, $type, $message);
        
        if ($stmt->execute()) {
            $successMessage = "Thank you for registering!";
            // Redirect to a success page after successful registration
            header("Location: ../events.html?status=success");
            exit();
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
        $stmt->close();
    }
    
    // Display appropriate message if not redirected
    if (isset($errorMessage)) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($errorMessage) . '</div>';
    }
}
$conn->close();
?>