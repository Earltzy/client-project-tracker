<?php
include "config.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $conn->query("INSERT INTO users (username, password) 
                  VALUES ('$username', '$password')");
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="register">Register</button>
</form>