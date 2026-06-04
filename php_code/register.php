<?php
session_start();
include 'lang.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $text[$lang]['welcome']; ?> | <?php echo "Register"; ?></title>
    <style>
        body {
            font-family: Georgia, serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #E5CEA1;
        }

        .container {
            width: 400px;
            background: #fff3e0;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: 1px solid #4C3220;
        }

        h2 {
            text-align: center;
            color: #4C3220;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #4C3220;
            font-size: 16px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #4C3220;
            border-radius: 5px;
            font-size: 15px;
        }

        .btn {
            display: block;
            width: 100%;
            background-color: #4C3220;
            color: #E5CEA1;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 17px;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #987654;
        }

        .links {
            text-align: center;
            margin-top: 15px;
        }

        .links a {
            text-decoration: none;
            color: #1976D2;
            font-size: 15px;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<div class="container">
    <h2><?php echo $text[$lang]['welcome']; ?></h2>

    <?php
    if (isset($_SESSION['register_error'])) {
        echo "<p style='color:red;'>".$_SESSION['register_error']."</p>";
        unset($_SESSION['register_error']);
    }
    if (isset($_SESSION['register_success'])) {
        echo "<p style='color:green;'>".$_SESSION['register_success']."</p>";
        unset($_SESSION['register_success']);
    }
    ?>

    <form action="register_process.php" method="POST">
        <label><?php echo "Name"; ?>:</label>
        <input type="text" name="name" required>

        <label><?php echo $text[$lang]['email']; ?>:</label>
        <input type="email" name="email" required>

        <label><?php echo $text[$lang]['password']; ?>:</label>
        <input type="password" name="password" required>

        <label><?php echo "Phone"; ?>:</label>
        <input type="text" name="phone" required>

        <label><?php echo $text[$lang]['language']; ?>:</label>
        <select name="language" required>
            <option value="en" <?php if($lang=='en') echo 'selected'; ?>>English</option>
            <option value="hi" <?php if($lang=='hi') echo 'selected'; ?>>Hindi</option>
            <option value="ta" <?php if($lang=='ta') echo 'selected'; ?>>Tamil</option>
        </select>

        <button type="submit" class="btn"><?php echo "Register"; ?></button>
    </form>

    <div class="links">
        <p><?php echo "Already have an account? "; ?><a href="login.php"><?php echo "Login here"; ?></a></p>
    </div>
</div>
</body>
</html>
