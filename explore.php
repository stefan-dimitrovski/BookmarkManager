<?php

include ('database.php');

$getAll = <<<HERE
        SELECT * FROM bookmarks
        WHERE is_public = 1
        group by tag
    HERE;

$stm = $dbo->prepare($getAll);

$stm->execute();

while($row = $stm->fetch()){

?>

<a href="public.php?tagname=<?=$row['tag']?>"><?=$row['tag']?></a><br>

<?php
}