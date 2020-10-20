<?php
    session_start();

    if (!$_SESSION['user']) {
        header('Location: ../profile/auth.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>MusicStorm</title>
</head>
<body>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'linear'
        });
    </script>

    <?php
        include_once "../sections/preloader.php";

        require_once "../config/connection.php";
        require_once "../config/db.php";

        include_once "../sections/nav.php";

        $title = "Top-3 Best performers";
        $query = "SELECT p.* FROM performers p INNER JOIN listenedperformers lp ON p.id = lp.performer_id AND lp.favourite = 1 GROUP BY p.id ORDER BY count(*) DESC, p.signupdate DESC";
        require_once "../list/performers.php";

        $title = "Top-3 Best albums";
        $query = "SELECT a.* FROM albums a INNER JOIN listenedalbums la ON a.id = la.album_id AND la.favourite = 1 GROUP BY a.id ORDER BY count(*) DESC, a.signupdate DESC";
        require_once "../list/albums.php";

        $title = "Top-3 Best tracks";
        $query = "SELECT t.* FROM tracks t INNER JOIN listenedtracks lt ON t.id = lt.track_id AND lt.favourite = 1 GROUP BY t.id ORDER BY count(*) DESC, t.signupdate DESC";
        require_once "../list/tracks.php";

        include_once "../sections/track.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="../script.js"></script> 
</body>
</html>