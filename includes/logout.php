<?php
session_start();

// Get the user session ID
$user_id = session_id();

// Include your database connection
// Replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials

$connection = mysqli_connect('localhost', 'admin', '52a6d848b3a02dec4792ba937d3a98f810a5b446af4da5d1', 'xogos');
if (!$connection) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Delete the user session from the users_online table
$delete_sessions_query = "DELETE FROM users_online WHERE session = '$user_id'";
mysqli_query($connection, $delete_sessions_query);

// Unset and destroy the session
unset($_SESSION['username']);
unset($_SESSION['user_id']);
session_destroy();

// Redirect to the login page
header('location: login.php');
exit();
?>
