<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $interest = $_POST["interest"];
    $entry = "Name: $name\nEmail: $email\nPhone: $phone\nInterest: $interest";
    file_put_contents("../messages/volunteers.txt", $entry . "\n---\n", FILE_APPEND);
    echo "Thank you for signing up!";
}
?>