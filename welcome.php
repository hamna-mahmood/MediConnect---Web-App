<?php
// Start session and get cookie if already set
session_start();

// If user already has a language cookie, preselect it
$lang = $_COOKIE['lang'] ?? 'en';
?>

<!DOCTYPE html>
<html>
<head>
    <title>MediConnect - Welcome</title>
    <style>
        body { background-color: #FCECCF;
font-family: Georgia, serif; 
color: #442D1D;
text-align:center; 
margin-top:100px; }
select, button { padding:10px; font-size:16px; margin-top:20px; }
    </style>
</head>
<body>

<h1>Welcome to MediConnect</h1>
<p>Select your language:</p>

<form action="set_language.php" method="POST">
    <select name="language" required>
        <option value="en" <?php if($lang=='en') echo 'selected'; ?>>English</option>
        <option value="hi" <?php if($lang=='hi') echo 'selected'; ?>>Hindi</option>
        <option value="ta" <?php if($lang=='ta') echo 'selected'; ?>>Tamil</option>
    </select>
    <br>
    <button type="submit">Next</button>
</form>

</body>
</html>
