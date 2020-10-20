<?php 
    session_start();

    require_once "../config/connection.php";
    require_once "../config/db.php";

    if (isset($_GET['id'])) {
        $id= $_GET['id'];

        $tracks = get_query($link, "SELECT * FROM tracks WHERE id = $id");

        foreach ($tracks as $track) { 
            foreach (get_query($link, "SELECT * FROM albums WHERE id = ".$track["album_id"]) as $album) {
                foreach (get_query($link, "SELECT * FROM performers WHERE id = ".$album["performer_id"]) as $performer) {
                    echo json_encode(array(
                        "track_name" => $track['_name'],
                        "track_source" => $track['_source'],
                        "album_name" => $album['_name'],
                        "album_avatar" => $album['avatar'],
                        "performer_name" => $performer['_name']
                    ));
                }
            }
        }
    }
?>
