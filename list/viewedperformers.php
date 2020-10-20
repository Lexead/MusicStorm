<section class="performers-section">
        <div class="performers-container">
            <div class="performers-title" data-aos="fade-down-right">
                <?php echo $title ?>
            </div>
            <div class="performer-list" data-aos="fade-down-left">
                <?php 
                    $check_performers = get_query($link, $query);

                    if (mysqli_num_rows($check_performers) > 0) {
                        foreach ($check_performers as $performer) { 
                ?>
                            <div class="performer-item">
                                <img src="<?php echo $performer["avatar"] ?>" class="performer-img">
                                <div class="performer-name"><?php echo $performer["_name"] ?></div>
                                <div class="performer-genre"><?php echo $performer["genres"] ?></div>
                                <div class="performer-info" data-aos="zoom-in"><?php echo "<p>" . str_replace(['\r\n', '\n', '\r'], '</p><p>', $performer["info"]) . "</p>"?></div>
                                <div class="performer-like" data-id="<?php echo $performer['id']?>" data-fav="<?php 
                                    foreach (get_query($link, "SELECT * FROM ListenedPerformers WHERE `performer_id` = ".$performer["id"]." AND `user_id` = ".$_SESSION['user']["id"]) as $listenedperformer) {
                                        echo $listenedperformer["favourite"];
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