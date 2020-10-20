<section class="performers-section">
    <div class="performers-container">
        <div class="performers-title" data-aos="fade-up-right">
            <?php echo $title ?>
        </div>
        <div class="performer-list" data-aos="fade-down-left">
            <?php 
                $check_performers = get_query($link, $query);

                if (mysqli_num_rows($check_performers) > 0) {

                    $i = 0;
                    foreach (get_query($link, $query . " LIMIT 3") as $performer) { 
                        $i++;
            ?>
                        <div class="performer-item">
                            <div class="performer-status"><?php echo $i?></div>
                            <img src="<?php echo $performer["avatar"] ?>" class="performer-img">
                            <a href="../performers?id=<?php echo $performer["id"]; ?>" class="performer-name"><?php echo $performer["_name"] ?></a>
                            <div class="performer-genre"><?php echo $performer["genres"] ?></div>
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
        <?php
            if(mysqli_num_rows($check_performers) > 3) {
        ?>
                <a href="../performers/" class="see-all" data-aos="fade-down-left">See all</a>
        <?php
            }
        ?>
    </div>
</section>
