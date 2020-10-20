<?php
    function get_query($link, $queryText) {
        $result = $link->query($queryText);
        if ($result) {
            return $result;
        }
        else {
            echo "Не удалось выполнить запрос: (" . $link->connect_errno . ") " . $link->connect_error; 
        }
    }
?>