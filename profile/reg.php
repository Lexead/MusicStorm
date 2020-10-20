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

        require_once "../config/connection.php";
        require_once "../config/db.php";
    ?>

    <section class="auth-section">
        <form class="reg-form">
            <h1>Registration</h1>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter your name">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your mail">
            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" placeholder="Enter your birthdate">
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="" hidden disabled selected>Select your gender...</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            <select>
            <label for="location">Location</label>
            <select name="location" id="location">
                <option value="" hidden disabled selected>Select your location...</option>
                <?php
                    foreach (get_query($link, "SELECT * FROM Locations ORDER BY country") as $location) {
                ?>
                    <option value="<?php echo $location['country'] ?>"><?php echo $location['country'] ?></option>
                <?php 
                    }
                ?>
            <select>
            <label for="avatar">Profile image</label>
            <input type="file" name="avatar" id="avatar">
            <div>
                <img id="avatar-result" src="" alt="">
                <label for="avatar" class="choose-avatar">Choose your avatar</label>    
            </div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter password">
            <div class="transition">
                Don't have an account? - <a href="auth.php">Log in</a>!
            </div>
            <button class="register-button">To register</button>
            <div class="message" style="display:none"></div>
        </form>
    </section> 

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>
</html>