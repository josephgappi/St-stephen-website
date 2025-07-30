<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = trim($_POST["message"]);
    
    // Convert line breaks to paragraphs
    $formattedMessage = '';
    $paragraphs = explode("\n\n", $message);
    foreach ($paragraphs as $paragraph) {
        if (!empty(trim($paragraph))) {
            $formattedMessage .= "<p>" . nl2br(htmlspecialchars($paragraph)) . "</p>\n";
        }
    }
    
    $fullMessage = "From: $name
Email: $email
Subject: $subject
Message:\n$formattedMessage";
    
    file_put_contents("../messages/contact.txt", $fullMessage . "\n---\n", FILE_APPEND);
    
    // For AJAX response
    echo "Thank you for your message! It has been sent successfully.";
    
    // Optional: Send email notification
    // $to = "your-email@example.com";
    // $headers = "From: $email\r\n";
    // $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    // mail($to, "New Contact Form Submission: $subject", $formattedMessage, $headers);
}
?>