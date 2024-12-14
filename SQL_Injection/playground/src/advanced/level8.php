<?php
session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    try {
        include("header.php");
        $database = make_connection("advanced_db");

        $sql = "SELECT username FROM users WHERE username=? and password=?";
        $statement = $database->prepare($sql);
        $passwordHash = md5($_POST['password']);
        $statement->bind_param('ss', $_POST['username'], $passwordHash);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($result);

        if ($statement->num_rows > 0) {
            $statement->fetch();
            $_SESSION["username"] = $result;
            die(header("Location: update.php"));
        } else {
            $message = "Wrong username or password"; 
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }
}

include("../basic/static/html/second-order.html");
// file này liên quan đến file update.php
// Level này đổi mật khẩu của admin, nhưng vì nó sẽ được md5 ra để so sánh, nên ta đổi mật khẩu của admin thành md5 của mật khẩu mình muốn, sau đó đăng nhập bằng plaintext mật khẩu đó
// payload: $email: t@t', password='1b2ccf52b54ea2c9468ca24fbe164919' WHERE username='admin' -- a
// Sau khi xong ta đăng nhập bình thường bằng admin và mật khẩu là alo(mã md5 trên là từ alo hash ra)