<section class="tracks-section">
    <div class="tracks-container">
        <div class="tracks-title" data-aos="fade-up-right">
            <?php echo $title ?>
        </div>
        <div class="track-list" data-aos="fade-down-left">
            <?php 
                require_once "../ID3/getid3/getid3.php";

                $check_tracks = get_query($link, $query);

                if (mysqli_num_rows($check_tracks) > 0) {

                    foreach ($check_tracks as $track) { 

                        $getID3 = new getID3;
                        $file = $getID3->analyze($track["_source"]);
                        $playtime_seconds = $file['playtime_seconds'];
            ?>
                        <div class="track-item">
                            <span class="track-play" data-id="<?php echo $track['id']?>"></span>
                            <span class="track-name"><a href="../tracks?id=<?php echo $track["id"]; ?>"><?php echo $track["_name"] ?></a></span>
                            <span class="track-album"><a href="../albums?id=<?php echo $track["album_id"]; ?>">
                                <?php foreach (get_query($link, "SELECT * FROM albums WHERE id = ".$track["album_id"]) as $album) {
                                    echo $album["_name"];
                                } ?>
                            </a></span>
                            <span class="track-duration"><?php echo gmdate("H:i:s", $playtime_seconds)?></span>
                            <span class="track-like" data-id="<?php echo $track['id']?>" data-fav="<?php 
                                foreach (get_query($link, "SELECT * FROM ListenedTracks WHERE `track_id` = ".$track["id"]." AND `user_id` = ".$_SESSION['user']["id"]) as $listenedtrack) {
                                    echo $listenedtrack["favourite"];
                                }
                            ?>"></span>
                        </div>
            <?php 
                    }
                } else {
            ?>
                    <div class="not-found" data-aos="fade-down-left">Not found</div>
            <?php
                }
            ?>
        </div>
    </div>
</section>