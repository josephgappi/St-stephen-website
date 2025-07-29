<?php
require_once 'config.php';

// Get all events from database
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Events - St. Stephen Church</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #2c3e50;
      --secondary-color: #3498db;
      --accent-color: #e74c3c;
      --background-color: #f8f9fa;
      --deep-blue: #1a2c3d;
      --primary-gold: #d4a56b;
      --text-dark: #333;
    }

    body {
      background-color: var(--background-color);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .events-section {
      padding: 5rem 0;
      background: linear-gradient(135deg, var(--deep-blue) 0%, rgba(26, 54, 93, 0.9) 100%);
      color: white;
    }

    .events-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      padding: 3rem;
      margin-top: 3rem;
      backdrop-filter: blur(10px);
    }

    .page-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .page-header h1 {
      color: var(--deep-blue);
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .event-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .event-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
    }

    .event-title {
      font-size: 1.5rem;
      font-weight: bold;
      color: var(--deep-blue);
    }

    .event-date {
      background: linear-gradient(45deg, var(--primary-gold), #e6b887);
      color: white;
      padding: 0.4rem 1rem;
      border-radius: 20px;
      font-size: 0.9rem;
      margin-top: 0.5rem;
      display: inline-block;
    }

    .event-details {
      margin-top: 1rem;
      font-size: 1rem;
      color: var(--text-dark);
    }

    .cta-button {
      background: linear-gradient(45deg, var(--primary-gold), #e6b887);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 25px;
      font-weight: 500;
      margin-top: 1rem;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
    }

    .cta-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(212, 165, 116, 0.4);
      color: white;
    }

    @media (max-width: 768px) {
      .events-container {
        padding: 2rem;
      }

      .page-header h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../index.html">
          <img src="../images/church logo.jpeg" alt="St. Stephen Church Logo" class="logo-img me-2">
          <span class="fw-bold text-white">St. Stephen Church</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="../index.html">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="../index.html#about">About</a></li>
            <li class="nav-item"><a class="nav-link" href="../index.html#services">Services</a></li>
            <li class="nav-item"><a class="nav-link active" href="events.php">Events</a></li>
            <li class="nav-item"><a class="nav-link" href="../donate.html">Donate</a></li>
            <li class="nav-item"><a class="nav-link" href="../index.html#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav>

  <section class="events-section">
    <div class="container">
      <div class="events-container">
        <div class="page-header">
          <a href="../index.html" class="btn btn-outline-custom mb-4"><i class="fas fa-arrow-left me-2"></i>Back to Home</a>
          <h1>Upcoming Events</h1>
          <p class="page-subtitle">Join us in fellowship and community service</p>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($event = mysqli_fetch_assoc($result)): ?>
        <div class="event-card">
          <div class="event-title"><?php echo htmlspecialchars($event['title']); ?></div>
          <div class="event-date"><?php echo date('F j, Y', strtotime($event['event_date'])); ?></div>
          <div class="event-details">
            <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            <p><strong>Time:</strong> <?php echo $event['event_time']; ?><br/>
            <strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
            <?php if ($event['registration_link']): ?>
            <a href="<?php echo htmlspecialchars($event['registration_link']); ?>" class="cta-button"><i class="fas fa-calendar-plus"></i> Register Now</a>
            <?php endif; ?>
          </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <div class="text-center py-5">
          <p class="text-muted">No upcoming events scheduled at this time.</p>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('status') === 'success') {
        alert("Registration successful!");
      }
    });
  </script>
</body>
</html>
