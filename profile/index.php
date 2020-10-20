<?php
    session_start();

    if (!$_SESSION['user']) {
        header('Location: auth.php');
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

        include_once "../sections/track.php";
    ?>

    <section class="profile-section">
        <div class="profile-container" data-aos="flip-right">
            <img src="<?php echo $_SESSION['user']["avatar"]?>" alt="avatar" class="profile-img">
            <a href="logout.php" class="profile-logout">Logout</a>
            <div class="profile-content">
                <div>
                    <span class="profile-name"><?php echo $_SESSION['user']["name"]?></span>
                    <span class="profile-email"><?php echo $_SESSION['user']["email"]?></span>
                </div>
            </div>
        </div>
    </section>

    <?php 
        $title = "Your favourite performers";
        $query = "SELECT p.*, count(lp.user_id) FROM performers p INNER JOIN listenedperformers lp ON p.id = lp.performer_id AND lp.user_id = ".$_SESSION['user']["id"]." AND lp.favourite = 1 GROUP BY p.id ORDER BY count(lp.user_id), lp.listening_date DESC";
        require_once "../list/foundedperformers.php";

        $title = "Your favourite albums";
        $query = "SELECT a.*, count(la.user_id) FROM albums a INNER JOIN listenedalbums la ON a.id = la.album_id AND la.user_id = ".$_SESSION['user']["id"]." AND la.favourite = 1 GROUP BY a.id ORDER BY count(la.user_id), la.listening_date DESC";
        require_once "../list/foundedalbums.php";

        $title = "Your favourite tracks";
        $query = "SELECT t.*, count(lt.user_id) FROM tracks t INNER JOIN listenedtracks lt ON t.id = lt.track_id AND lt.user_id = ".$_SESSION['user']["id"]." AND lt.favourite = 1 GROUP BY t.id ORDER BY count(lt.user_id), lt.listening_date DESC";
        require_once "../list/foundedtracks.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="../script.js"></script> 
</body>
</html>