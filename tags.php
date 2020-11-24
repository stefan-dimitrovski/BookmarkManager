<?php

include ('database.php');

$query = <<<HERE
    SELECT * FROM bookmarks
    WHERE user_id = :uid
HERE;

$stm = $dbo->prepare($query);

$stm->bindParam(":uid", $_COOKIE['userid'], PDO::PARAM_STR);

$stm->execute();

while($row = $stm->fetch()) {

    echo "<a href='bookmarks.php'>{$row['tag']}</a><br>";
}



