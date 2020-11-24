<?php

include ('database.php');

?>

<a href="explore.php">Public tags</a><br>

<form action="bookmarks.php" method="POST">
    <label for="url">URL: </label>
    <input id="url" type="text" name="url"><br><br>
    <label for="tag">Tag: </label>
    <select id="tag" name="tag">
        <option value="php">php</option>
        <option value="work">work</option>
        <option value="todo">todo</option>
        <option value="db">db</option>
    </select><br><br>
    <label for="comment">Comment: </label>
    <input id="comment" type="text" name="comment"><br><br>
    <label for="pub">Public ? </label>
    <select id="pub" name="pub">
        <option value="1">yes</option>
        <option value="0">no</option>
    </select><br><br>
    <input type="submit" name="submit">
</form>


<?php

    if(isset($_POST['submit'])){
        $query2 = <<<HERE
            INSERT INTO bookmarks(url, tag, created, comment, is_public, user_id) 
            VALUE ( :url , :tg , NOW() , :cmt, :pub, :uid);
        HERE;

        $stm2 = $dbo->prepare($query2);

        $stm2->bindParam(":url",$_POST['url'], PDO::PARAM_STR);
        $stm2->bindParam(":tg",$_POST['tag'], PDO::PARAM_STR);
        $stm2->bindParam(":cmt",$_POST['comment'], PDO::PARAM_STR);
        $stm2->bindParam(":pub",$_POST['pub'], PDO::PARAM_INT);
        $stm2->bindParam(":uid",$_COOKIE['userid'], PDO::PARAM_INT);

        $stm2->execute();

    }
?>

<?php
    $getAll = <<<HERE
        SELECT * FROM bookmarks
        WHERE user_id = :uid
        ORDER BY created desc;
    HERE;

    $stm3 = $dbo->prepare($getAll);
    $stm3->bindParam(":uid",$_COOKIE['userid'], PDO::PARAM_INT);

    $stm3->execute();

    while($row = $stm3->fetch()){

?>

<table id="table">
    <thead>
    <th>url</th>
    <th>tag</th>
    <th>created</th>
    <th>comment</th>
    <th>public</th>
    </thead>
    <tbody>
    <tr>
        <td><?=$row['url']?></td>
        <td><?=$row['tag']?></td>
        <td><?=$row['created']?></td>
        <td><?=$row['comment']?></td>
        <td><?=$row['is_public']?></td>
    </tr>
    </tbody>
</table>


<?php
    }

