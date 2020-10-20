<?php
    session_start();

    if ($_SESSION['user']) {
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Lato|Nanum+Gothic|Spartan&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>MusicStorm</title>
</head>
<body>
    <?php
        include_once "../sections/preloader.php"; 
    ?>

    <section class="auth-section">
        <form class="auth-form">
            <h1>Authorization</h1>
            <label for="email">Login</label>
            <input type="email" name="email" id="email" placeholder="Enter your email">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter password">
            <div class="transition">
                Already have an account? - <a href="reg.php">Register</a>!
            </div>
            <button class="login-button">Sign in</button>
            <div class="message" style="display:none"></div>
        </form>
    </section> 

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>
</html>