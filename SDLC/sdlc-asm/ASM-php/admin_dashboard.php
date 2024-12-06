<?php
session_start();

// Kiểm tra quyền truy cập
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Đảm bảo đường dẫn chính xác đến file CSS -->
    <link rel="stylesheet" href="admin_dashboard.css"> <!-- Ví dụ đường dẫn chính xác -->
    <link rel="icon" href="data:,"> <!-- Bỏ qua favicon nếu không có -->
</head>

<body>
    <div class="container">
        <h1>Chào mừng Admin</h1>
        <a href="manage_students.php">Quản lý sinh viên</a><br>
        <a href="manage_teachers.php">Quản lý giáo viên</a><br>
        <a href="manage_classes.php">Quản lý lớp học</a><br>
        <a href="manage_courses.php">Quản lý khóa học</a><br>
        <a href="login.php">Đăng xuất</a>
    </div>
</body>

</html>