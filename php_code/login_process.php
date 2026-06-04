<?php
session_start();
include 'lang.php';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Connect to DB
    $conn = new mysqli("localhost","root","","mediconnect");
    if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

    // Get inputs
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = strtolower(trim($_POST['role']));
    $language = $_POST['language'] ?? 'en';

    // Set language cookie & session
    setcookie("lang", $language, time() + (86400*30), "/");
    $_SESSION['lang'] = $language;

    // Map role to table & redirect
    switch($role){
        case 'patient':
            $table = 'patient';
            $redirect = 'search.php'; // updated to patient search page
            break;
        case 'pharmacy':
            $table = 'pharmacy';
            $redirect = 'pharmacy_dashboard.php';
            break;
        case 'delivery_agent':
            $table = 'delivery_agent';
            $redirect = 'delivery_dashboard.php';
            break;
        default:
            $_SESSION['login_error'] = "Invalid role selected!";
            header("Location: login.php"); 
            exit();
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $_SESSION['login_error'] = "Email not found!";
        header("Location: login.php"); 
        exit();
    }

    $row = $result->fetch_assoc();

    // Password verification
    if (!password_verify($password, $row['password'])) {
        $_SESSION['login_error'] = "Incorrect password!";
        header("Location: login.php"); 
        exit();
    }

    // Successful login → set session variables
    $_SESSION['role'] = $role;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_id'] = $row['id']; // store user ID for later use

    // Optional: store user's name if patient
    if($role === 'patient') {
        $_SESSION['user_name'] = $row['name'];
    }

    // Redirect to role-specific page
    header("Location: $redirect");
    exit();
}
?>
