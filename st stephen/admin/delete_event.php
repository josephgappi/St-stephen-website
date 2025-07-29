<?php
session_start();
require_once '../php/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get event ID from URL
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get event details to delete image if exists
$sql = "SELECT image_url FROM events WHERE id = $event_id";
$result = mysqli_query($conn, $sql);
$event = mysqli_fetch_assoc($result);

// Delete event
$sql = "DELETE FROM events WHERE id = $event_id";
if (mysqli_query($conn, $sql)) {
    // Delete image if exists
    if ($event && $event['image_url'] && file_exists('../' . $event['image_url'])) {
        unlink('../' . $event['image_url']);
    }
    header("Location: dashboard.php?status=success");
    exit();
} else {
    header("Location: dashboard.php?status=error&message=" . urlencode("Error deleting event"));
    exit();
}
?>
