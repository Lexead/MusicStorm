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

        $check_track = $link->query("SELECT * FROM ListenedTracks WHERE `user_id`=$user_id AND `track_id`=$id");
        if (mysqli_num_rows($check_track) > 0) {
            $link->query("UPDATE ListenedTracks SET listening_date='$currentdate' WHERE `user_id`=$user_id AND `track_id`=$id");
        } else {
            $link->query("INSERT INTO ListenedTracks VALUES (0, $user_id, $id, '$currentdate', 0)");
        }
        
        $link->query("UPDATE ListenedTracks SET favourite=$fav WHERE `user_id`=$user_id AND `track_id`=$id");

        foreach ($link->query("SELECT * FROM ListenedTracks WHERE `user_id`=$user_id AND `track_id`=$id") as $listenedtrack) {
            echo json_encode(array(
                "favourite" => $listenedtrack['favourite']
            ));
        }
    }
?>