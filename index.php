<?php

require_once ('database.php');

$referer = null;
//session_start();

if(!empty($_SERVER['HTTP_REFERER'])){
    $referer = $_SERVER['HTTP_REFERER'];
}

if(isset($_COOKIE['last_access'])){
    $last_access = $_COOKIE['last_access'];
    $current = time();

    if($current - $last_access < 3600){
        header("Location: {$referer}tags.php");
    }else{

    }
}

?>

<form action="" method="POST">
    <label for="email">Email: </label>
    <input id="email" type="text" name="email" value=""><br><br>
    <label for="password">Password: </label>
    <input id="password" type="text" name="password" value=""><br><br>
    <input type="submit" name="submit">
</form>
<a href="register.php">register</a>

<?php

if (isset($_POST['submit'])){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        echo "email invalid";
    }
    else if(empty($_POST['password'])){
        echo "password required";
    }
    else{

        $query = <<<HERE
            SELECT * FROM users
            WHERE email = :em
        HERE;

        $stm = $dbo->prepare($query);

        $stm->bindParam(":em", $_POST['email'], PDO::PARAM_STR);

        $stm->execute();

        $answer = $stm->fetch();

        $passwordHash = hash("sha256", $_POST['password']);

        $answerPass = $answer[2];

        $userid = $answer[0];

        if($answerPass == $passwordHash){
            setcookie("email", $_POST['email']);
            $passwordHash =  hash("sha256", $_POST['password']);
            setcookie("password", $passwordHash);
            setcookie("userid", $userid);
            setcookie("last_access", time());

            header("Location: {$referer}tags.php");
        }else{
            echo "User doesn't exist please register";
        }
    }
}
