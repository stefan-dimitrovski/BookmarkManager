<?php
include_once("db.php");

$dbo = NULL;

// Try to connect to the database using PDO
try {
    $dbo = new PDO("{$DB_TYPE}:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER, $DB_PASS);
    //echo "{$DB_TYPE}:host={$DB_HOST};dbname={$DB_NAME}";
}
catch (PDOException $pEx){
    print ("Error:" . $pEx->getMessage() . '<br />');
    die();
}
catch (Exception $Ex){
    $error_message = $e->getMessage();
    echo $error_message;
    exit();
}