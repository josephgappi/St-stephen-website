<?php
header('Content-Type: application/json');
require_once 'config.php';

// Get all events from database
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = [
        'title' => htmlspecialchars($row['title']),
        'date' => date('F j, Y', strtotime($row['event_date'])),
        'time' => $row['event_time'],
        'description' => nl2br(htmlspecialchars($row['description'])),
        'location' => htmlspecialchars($row['location']),
        'registration_link' => $row['registration_link']
    ];
}

echo json_encode($events);
?>
