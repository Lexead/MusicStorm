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
            $title = "About Performer";
            $query = "SELECT * FROM performers WHERE id = $id";
            require_once "../list/viewedperformers.php";

            $title = "Performer's albums";
            $query = "SELECT a.* FROM albums a WHERE a.performer_id = $id GROUP BY a.id ORDER BY a._year DESC, a.signupdate DESC";
            require_once "../list/foundedalbums.php";

            $title = "Performer's tracks";
            $query = "SELECT t.* FROM tracks t INNER JOIN albums a ON t.album_id = a.id AND a.performer_id = $id GROUP BY t.id ORDER BY a._year DESC, t.signupdate DESC";
            require_once "../list/foundedtracks.php";
        }
        else {
            $title = "All Performers";
            $query = "SELECT p.* FROM performers p INNER JOIN listenedperformers lp ON lp.performer_id = p.id and lp.favourite = 1 GROUP BY p.id ORDER BY count(*) DESC, lp.listening_date DESC LIMIT 33";
            require_once "../list/foundedperformers.php";
        }

        include_once "../sections/track.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>
</html>