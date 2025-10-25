<?php
// Start session and set login flag before any HTML output
session_start();
require 'includes/user-class.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

header("Location: pages/toeslagen.php");
exit;
?>

<!-- 

if user == loggedin {
	../toeslagen/toeslagen.php
} else {
	../toeslagen/toeslagen.php
}

-->