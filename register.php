<?php

include ('database.php');

$referer = null;

if(!empty($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
}

?>

<form action="register.php" method="POST">
    <label for="email">Email: </label>
    <input id="email" type="text" name="email"><br><br>
    <label for="password">Password: </label>
    <input id="password" type="text" name="password"><br><br>
    <label for="passwordRetype">Repeat Password: </label>
    <input id="passwordRetype" type="text" name="passwordRetype"><br><br>
    <input type="submit" name="submit">
</form>

<?php

    if(isset($_POST['submit'])){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            echo "email invalid";
            return;
        }
        else if(empty($_POST['password'])){
            echo "password required";
            return;
        }
        else if($_POST['password'] != $_POST['passwordRetype']){
            echo "password do not match";
            return;
        }
        else{
            $query = <<<HERE
        INSERT INTO users(email, password, last_login) value ( :em , :pw , NOW());
    HERE;

            $stm = $dbo->prepare($query);

            $stm->bindParam(":em", $_POST['email'], PDO::PARAM_STR);
            $passwordHash =  hash("sha256", $_POST['password']);
            $stm->bindParam(":pw", $passwordHash, PDO::PARAM_STR);

            $stm->execute();

            header("Location: index.php");
        }
    }
