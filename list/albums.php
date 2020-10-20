<section class="albums-section">
    <div class="albums-container">
        <div class="albums-title" data-aos="fade-up-right">
            <?php echo $title ?>
        </div>
        <div class="album-list" data-aos="fade-down-left">
            <?php 
                $check_albums = get_query($link, $query);

                if (mysqli_num_rows($check_albums) > 0) {

                    $i = 0;
                    foreach (get_query($link, $query . " LIMIT 3") as $album) { 
                        $i++;
            ?>
                        <div class="album-item">
                            <div class="album-status"><?php echo $i?></div>
                            <img src="<?php echo $album["avatar"] ?>" class="album-img">
                            <a href="../albums?id=<?php echo $album["id"]; ?>" class="album-name"><?php echo $album["_name"] ?></a>
                            <a href="../performers?id=<?php echo $album["performer_id"]; ?>" class="album-author">
                                <?php foreach (get_query($link, "SELECT * FROM performers WHERE id = ".$album["performer_id"]) as $performer) {
                                    echo $performer["_name"];
                                } ?>, 
                                <?php
                                    echo $album["_year"];
                                ?>
                            </a>
                            <div class="album-like" data-id="<?php echo $album['id']?>" data-fav="<?php 
                                foreach (get_query($link, "SELECT * FROM ListenedAlbums WHERE `album_id` = ".$album["id"]." AND `user_id` = ".$_SESSION['user']["id"]) as $listenedalbum) {
                                    echo $listenedalbum["favourite"];
                                }
                            ?>"></div>
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
        <?php
            if(mysqli_num_rows($check_albums) > 3) {
        ?>
                <a href="../albums" class="see-all" data-aos="fade-down-left">See all</a>
        <?php
            }
        ?>
    </div>
</section>