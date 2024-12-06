<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Thực hiện truy vấn để tìm người dùng với email
    $sql = "SELECT * FROM users WHERE email = '$email'";  // Tìm theo email
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // So sánh mật khẩu thuần túy
        if ($password === $user['password']) {  // So sánh trực tiếp
            $_SESSION['user_id'] = $user['user_id'];  // Lưu user_id vào session
            $_SESSION['role'] = $user['role'];  // Lưu role vào session

            // Chuyển hướng theo role của người dùng
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                echo "Đăng nhập thành công! <a href='user_dashboard.php'>Tiếp tục</a>";
            }
        } else {
            echo "Mật khẩu không đúng!";
        }
    } else {
        echo "Email không tồn tại!";
    }
}
?>

<head>
    <link rel="stylesheet" href="login.css"> <!-- Đảm bảo đường dẫn đúng với vị trí của file register.css -->
</head>

<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <button type="submit">Login</button>
    <a href="register.php">Don't have an account? Register here</a>
</form>