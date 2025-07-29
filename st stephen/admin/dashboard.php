<?php
session_start();
require_once '../php/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get all events
$sql = "SELECT * FROM events ORDER BY event_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - St. Stephen's Church</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet" />
  

  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .navbar {
      flex-shrink: 0;
    }
    .dashboard-wrapper {
      display: flex;
      flex: 1 0 auto;
      min-height: calc(100vh - 56px); /* navbar height */
    }
    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color:rgb(3, 31, 58);
      color: white;
      padding: 1rem;
    }
    .sidebar a {
      color:rgb(70, 201, 38);
      text-decoration: none;
      display: block;
      padding: 0.75rem 0;
      border-radius: 6px;
      font-weight: 500;
    }
    .sidebar a:hover {
      background-color: #2c3e50;
      color: #f5d187;
    }
    /* Content area */
    .content {
      flex-grow: 1;
      padding: 2rem;
      background: #f8f9fa;
      overflow-y: auto;
    }

    /* Card spacing */
    .card + .card {
      margin-top: 2rem;
    }

    /* Event table adjustments */
    table th, table td {
      vertical-align: middle;
    }

    /* Summernote fixes */
    .note-editor.note-frame {
      border-radius: 0.375rem;
      border-color: #ced4da;
      box-shadow: none;
    }
  </style>
</head>
<body>


<div class="dashboard-wrapper">
  <nav class="sidebar">
    <div class="sidebar-header d-flex align-items-center mb-4">
      <img src="../images/church logo.jpeg" alt="St. Stephen Church Logo" class="logo-img me-2 mb-2">
      <span class="fw-bold text-white">Admin Panel</span>
    </div>
    <a href="#" class="active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
    <a href="#"><i class="fas fa-users me-2"></i>Manage Users</a>
  </nav>

  <main class="content">
    <div class="container">
      <div class="page-header mb-4">
        <h2 class="text-center mb-3">Admin Dashboard</h2>
        <p class="text-center text-muted">Manage church events and content</p>
      </div>

    <!-- Add New Event Form -->
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add New Event</h5>
      </div>
      <div class="card-body">
        <form action="add_event.php" method="POST" enctype="multipart/form-data" id="addEventForm">
          <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" required />
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="date" class="form-label">Event Date</label>
              <input type="date" class="form-control" id="date" name="date" required />
            </div>
            <div class="col-md-6 mb-3">
              <label for="time" class="form-label">Event Time</label>
              <input type="time" class="form-control" id="time" name="time" required />
            </div>
          </div>
          <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required />
          </div>
          <div class="mb-3">
            <label for="registration_link" class="form-label">Registration Link (optional)</label>
            <input type="url" class="form-control" id="registration_link" name="registration_link" />
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Event Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Event Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" />
          </div>
          <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
      </div>
    </div>

    <!-- Events List -->
    <div class="card shadow-sm mt-5">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Events List</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-hover mb-0">
            <thead class="table-primary">
              <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th style="width:150px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo date('F j, Y', strtotime($row['event_date'])); ?></td>
                <td><?php echo $row['event_time']; ?></td>
                <td>
                  <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning me-1">Edit</a>
                  <a href="delete_event.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                </td>
              </tr>
              <?php endwhile; ?>
              <?php if(mysqli_num_rows($result) == 0): ?>
              <tr><td colspan="4" class="text-center">No events found.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

<style>
  .logo-img {
    height: 40px;
    width: auto;
  }

  .sidebar-header {
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .sidebar a {
    padding-left: 1.5rem;
  }

  .sidebar i {
    width: 20px;
    text-align: center;
  }

  .page-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  .page-header h2 {
    color: var(--deep-blue);
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
  }

  .page-header p {
    font-size: 1.1rem;
    color: var(--text-dark);
    opacity: 0.9;
  }
</style>

<!-- JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Needed for Summernote -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
  $(document).ready(function() {
    $('#description').summernote({
      height: 200,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'video']]
      ]
    });
  });
</script>
</body>
</html>
