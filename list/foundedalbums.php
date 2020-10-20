<section class="albums-section">
        <div class="albums-container">
            <div class="albums-title" data-aos="fade-down-right">
                <?php echo $title ?>
            </div>
            <div class="album-list" data-aos="fade-down-left">
                <?php 
                    $check_albums = get_query($link, $query);

                    if (mysqli_num_rows($check_albums) > 0) {

                        foreach ($check_albums as $album) { 
                ?>
                            <div class="album-item">
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
        </div>
</section>