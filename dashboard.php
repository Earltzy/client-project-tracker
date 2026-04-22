<?php
session_start();
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$clients = $conn->query("SELECT COUNT(*) as total FROM clients")->fetch_assoc()['total'];
$projects = $conn->query("SELECT COUNT(*) as total FROM projects")->fetch_assoc()['total'];

$pending = $conn->query("SELECT COUNT(*) as total FROM projects WHERE status='pending'")->fetch_assoc()['total'];
$ongoing = $conn->query("SELECT COUNT(*) as total FROM projects WHERE status='ongoing'")->fetch_assoc()['total'];
$completed = $conn->query("SELECT COUNT(*) as total FROM projects WHERE status='completed'")->fetch_assoc()['total'];
?>

<h2>Dashboard</h2>

<div style="display:flex; gap:20px; flex-wrap:wrap;">

    <div style="padding:20px; border:1px solid #ccc;">
        <h3>Total Clients</h3>
        <p><?php echo $clients; ?></p>
    </div>

    <div style="padding:20px; border:1px solid #ccc;">
        <h3>Total Projects</h3>
        <p><?php echo $projects; ?></p>
    </div>

    <div style="padding:20px; border:1px solid #ccc;">
        <h3>Pending</h3>
        <p><?php echo $pending; ?></p>
    </div>

    <div style="padding:20px; border:1px solid #ccc;">
        <h3>Ongoing</h3>
        <p><?php echo $ongoing; ?></p>
    </div>

    <div style="padding:20px; border:1px solid #ccc;">
        <h3>Completed</h3>
        <p><?php echo $completed; ?></p>
    </div>

</div>

<br>

<a href="clients.php">Manage Clients</a> |
<a href="projects.php">Manage Projects</a>