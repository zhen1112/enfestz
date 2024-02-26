<?php
session_start();

// Check if the form was submitted and the destroy_session button was pressed
if (isset($_POST['destroy_session'])) {
    // Destroy the session
    session_destroy();
    // Redirect to a page after destroying the session if needed
    header("Location: index.php"); // Change 'index.php' to the desired page
    exit();
}

// Rest of your existing code for processing the form data
?>
