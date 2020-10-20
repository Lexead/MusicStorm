<?php
    session_start();

    require_once "../config/connection.php";
    require_once "../config/db.php";

    if (isset($_GET['id']) && isset($_GET['fav'])) {
        $id= $_GET['id'];
        $user_id = $_SESSION['user']["id"];
        $currentdate = date('Y-m-d H:i:s', strtotime("now"));
        $fav = $_GET['fav'];

        if ($fav == 0) {
            $fav = 1;
        } else {
            $fav = 0;
        } 

        $check_album = $link->query("SELECT * FROM ListenedAlbums WHERE `user_id`=$user_id AND `album_id`=$id");
        if (mysqli_num_rows($check_album) > 0) {
            $link->query("UPDATE ListenedAlbums SET listening_date='$currentdate' WHERE `user_id`=$user_id AND `album_id`=$id");
        } else {
            $result = $link->query("INSERT INTO ListenedAlbums VALUES (0, $user_id, $id, '$currentdate', 0)");
        }
        
        $link->query("UPDATE ListenedAlbums SET favourite=$fav WHERE `user_id`=$user_id AND `album_id`=$id");

        foreach ($link->query("SELECT * FROM ListenedAlbums WHERE `user_id`=$user_id AND `album_id`=$id") as $listenedalbum) {
            echo json_encode(array(
                "favourite" => $listenedalbum['favourite']
            ));
        }
    }
?>