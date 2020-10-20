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

        if (isset($_GET['text']) && $_GET['text'] !== '') {
            $text = $_GET['text'];

            $title = "Performers search results by « $text »";
            $query = "SELECT * FROM performers WHERE _name LIKE '$text%'";
            require_once "../list/foundedperformers.php";

            $title = "Albums search results by « $text »";
            $query = "SELECT * FROM albums WHERE _name LIKE '$text%'";
            require_once "../list/foundedalbums.php";

            $title = "Tracks search results by « $text »";
            $query = "SELECT * FROM tracks WHERE _name LIKE '$text%'";
            require_once "../list/foundedtracks.php";
        }
        else if (isset($_GET['genre']) && $_GET['genre'] !== '') {
            $genre = $_GET['genre'];

            $title = "Performers search results by « $genre »";
            $query = "SELECT * FROM performers WHERE genres LIKE '%$genre%'";
            require_once "../list/foundedperformers.php";

            $title = "Albums search results by « $genre »";
            $query = "SELECT a.* FROM albums a INNER JOIN performers p ON a.performer_id = p.id WHERE p.genres LIKE '%$genre%'";
            require_once "../list/foundedalbums.php";

            $title = "Tracks search results by « $genre »";
            $query = "SELECT t.* FROM tracks t INNER JOIN albums a INNER JOIN performers p ON t.album_id = a.id AND a.performer_id = p.id WHERE p.genres LIKE '%$genre%'";
            require_once "../list/foundedtracks.php";
        }
        else {
            echo "Sorry, library don't have such performer / album / track";
        }

        include_once "../sections/track.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>
</html>