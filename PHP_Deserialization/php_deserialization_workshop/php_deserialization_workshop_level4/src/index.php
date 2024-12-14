<?php
// include các thư viện trong compose
require('vendor/autoload.php');

// Chỉ include file cần thiết
include("libs/student.php");

session_start();

if (!isset($_SESSION["students"]))
    $_SESSION["students"] = array();
    
if (isset($_POST["name"]) && isset($_POST["age"])) {
    $student = new Student($_POST["name"], $_POST["age"]);
    array_push($_SESSION["students"], $student);
}

include("save-load.php");
?>

<html>
    <?php include("templates/header.php") ?>
    <?php include("templates/load_form.php") ?>
    <?php include("templates/table.php") ?>
    <?php include("templates/footer.php") ?>
</html>