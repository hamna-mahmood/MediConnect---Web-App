<?php
session_start();
include 'lang.php'; // Read language cookie if set
?>

<html>
<head>
    <title><?php echo $text[$lang]['welcome']; ?> | Login</title>
    <style>
        body {
            font-family: Georgia, serif;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        .main {
            display: flex;
            height: 100vh;
        }

        /* --- LEFT SIDE WITH BACKGROUND --- */
        .image-side {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;

            background-image: url('bg.png');
            background-size: cover;       /* cover the full container */
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .image-side .main-img {
            max-width: 70%;
            max-height: 70%;
            object-fit: contain;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            z-index: 2;
        }

        /* --- RIGHT LOGIN FORM --- */
        .login-side {
            width: 50%;
            background-color: #E5CEA1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 400px;
            background: #E5CEA1;
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

        /* --- RESPONSIVE ADJUSTMENTS --- */
        @media (max-width: 900px) {
            .main {
                flex-direction: column;
            }
            .image-side, .login-side {
                width: 100%;
                height: 50vh;
            }
        }
    </style>
</head>

<body>
<div class="main">
    <!-- LEFT IMAGE WITH BACKGROUND -->
    <div class="image-side">
        <img src="img.jpeg" class="main-img">
    </div>

    <!-- RIGHT LOGIN FORM -->
    <div class="login-side">
        <div class="container">
            <h2><?php echo $text[$lang]['welcome']; ?></h2>

            <?php
            if(isset($_SESSION['login_error'])){
                echo "<p style='color:red'>".$_SESSION['login_error']."</p>";
                unset($_SESSION['login_error']);
            }
            ?>

            <form action="login_process.php" method="POST">
                <label><?php echo $text[$lang]['language']; ?>:</label>
                <select name="language" required>
                    <option value="en" <?php if($lang=='en') echo 'selected'; ?>>English</option>
                    <option value="hi" <?php if($lang=='hi') echo 'selected'; ?>>Hindi</option>
                    <option value="ta" <?php if($lang=='ta') echo 'selected'; ?>>Tamil</option>
                </select>

                <label><?php echo $text[$lang]['email']; ?>:</label>
                <input type="email" name="email" required>

                <label><?php echo $text[$lang]['password']; ?>:</label>
                <input type="password" name="password" required>

                <label><?php echo $text[$lang]['login_as']; ?>:</label>
                <select name="role" required>
                    <option value=""><?php echo "--Select Role--"; ?></option>
                    <option value="patient"><?php echo $text[$lang]['patient']; ?></option>
                    <option value="pharmacy"><?php echo $text[$lang]['pharmacy']; ?></option>
                    <option value="delivery_agent"><?php echo $text[$lang]['delivery']; ?></option>
                </select>

                <button type="submit" class="btn"><?php echo $text[$lang]['dashboard']; ?></button>
            </form>

            <div class="links">
                <p><?php echo "Don't have an account? "; ?><a href="register.php"><?php echo "Register here"; ?></a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
