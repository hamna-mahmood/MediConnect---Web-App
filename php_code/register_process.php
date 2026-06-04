<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "mediconnect");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data and trim whitespace
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$phone = trim($_POST['phone'] ?? '');
$role = 'patient'; // Only patients can register
$language = $_POST['language'] ?? 'en'; // Get chosen language

// Set language cookie
setcookie("lang", $language, time() + (86400*30), "/");
$_SESSION['lang'] = $language;

// Basic validation
if (!$name || !$email || !$password || !$phone) {
    $_SESSION['register_error'] = "All fields are required!";
    header("Location: register.php");
    exit();
}

// Optional: Validate phone number format (10-15 digits)
if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
    $_SESSION['register_error'] = "Invalid phone number!";
    header("Location: register.php");
    exit();
}

// Check if email already exists
$check = $conn->prepare("SELECT email FROM patient WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) {
    $_SESSION['register_error'] = "Email already registered!";
    header("Location: register.php");
    exit();
}
$check->close();

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO patient (name, email, password, phone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashed_password, $phone);

// Execute
if (!$stmt->execute()) {
    $_SESSION['register_error'] = "Registration failed! Please try again.";
    header("Location: register.php");
    exit();
} else {
    // Registration successful → redirect to login
    $_SESSION['register_success'] = "Registration successful! Please log in.";
    header("Location: login.php");
    exit();
}

// Close connections
$stmt->close();
$conn->close();
?>
