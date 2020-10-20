<?php
    require_once "settings.php";

    $link = new mysqli(
        $connection["host"],
        $connection["username"],
        $connection["password"],
        $connection["database"], 
        $connection["port"]
    );
    
    if ($link->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
    }
?>