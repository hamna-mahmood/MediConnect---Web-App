<?php
// Get language from form
$language = $_POST['language'] ?? 'en';

// Set cookie for 30 days
setcookie("lang", $language, time() + (86400*30), "/");

// Optional: store in session too
session_start();
$_SESSION['lang'] = $language;

// Redirect to login page
header("Location: login.php");
exit();
?>
