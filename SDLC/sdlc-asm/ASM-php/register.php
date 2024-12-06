<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];  

    
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')";

    if ($conn->query($sql) === TRUE) {
        echo "Đăng ký thành công! <a href='login.php'>Đăng nhập</a>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>


<head>
    <link rel="stylesheet" href="register.css"> 
</head>

<form method="post">
    <input type="text" name="username" placeholder="Tên người dùng" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <button type="submit">Đăng ký</button>
</form>