<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $fullMessage = "From: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
    file_put_contents("../messages/contact.txt", $fullMessage . "\n---\n", FILE_APPEND);
    echo "Thank you for your message!";
}
?>