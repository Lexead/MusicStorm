<?php
    session_start();
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

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $title = "About album";
            $query = "SELECT * FROM albums WHERE id = $id";
            require_once "../list/viewedalbums.php";

            $title = "Album's tracks";
            $query = "SELECT t.* FROM tracks t WHERE t.album_id = $id GROUP BY t.id ORDER BY t.signupdate DESC";
            require_once "../list/foundedtracks.php";
        }    
        else {
            $title = "All albums";
            $query = "SELECT * FROM albums LIMIT 33";
            require_once "../list/foundedalbums.php";
        }

        include_once "../sections/track.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>
</html>