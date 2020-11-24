<?php

include ('database.php');

$tagtype = $_REQUEST['tagname'];

$getAll = <<<HERE
        SELECT * FROM bookmarks
        WHERE is_public = 1 and tag = :tg and user_id != :uid
    HERE;

$stm = $dbo->prepare($getAll);

$stm->bindParam(":tg", $tagtype, PDO::PARAM_STR);
$stm->bindParam(":uid", $_COOKIE['userid'], PDO::PARAM_INT);

$stm->execute();

while($row = $stm->fetch()){

    ?>

    <table id="table">
        <thead>
        <th>url</th>
        <th>tag</th>
        <th>created</th>
        </thead>
        <tbody>
        <tr>
            <td><?=$row['url']?></td>
            <td><?=$row['tag']?></td>
            <td><?=$row['created']?></td>
        </tr>
        </tbody>
    </table>

    <?php
}