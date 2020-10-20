<?php
    session_start();
?>

<nav class="nav-section">
    <ul class="section-list">
      <li>
        <a href="../home/"><img src="../images/logo.png" class="logo"></a>
      </li>
      <hr>
      <li>
        <input type="text" class="search-input" placeholder="Search">
        <div class="search-button"></div>
      </li>
      <hr>
      <li>
        <a class="text" href="../home/">Main</a>
      </li>
      <li>
        <a class="text" href="../genres/">Genres</a>
      </li>
      <li>
        <a class="text" href="../playlist/">Playlist</a>
      </li>
      <hr>
      <li>
        <a class="text" href="../profile/">Profile</a>
      </li>
      <li>
        <a href="../profile/">
            <?php
              if ($_SESSION['user']) {
            ?>
                <img src="<?php echo $_SESSION['user']["avatar"]?>" alt="avatar" class="avatar">
            <?php  
              } 
            ?>
        </a>
      </li>
    </ul>
</nav>