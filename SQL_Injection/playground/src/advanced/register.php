<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        include("header.php");
        $database = make_connection("advanced_db");
        
        $sql = "SELECT username from users where username=?";
        $statement = $database->prepare($sql);
        $statement->bind_param('s', $_POST['username']);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows() > 0) {
            $message = "Sorry this username already registered";
        } else {
            $sql = "INSERT INTO users(username, password, email) VALUES (?, ?, ?)";
            $statement = $database->prepare($sql);
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $email = $_POST['email'];
            $statement->bind_param('sss', $username, $password, $email);
            $statement->execute();
            $message = "Create successful";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }
}

include("../basic/static/html/register.html");
