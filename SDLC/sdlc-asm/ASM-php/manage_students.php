<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $user_id = 1;  // Giả sử `user_id` là một giá trị cố định hoặc bạn có thể lấy từ session của người dùng.

    // Thêm sinh viên vào bảng students
    $sql = "INSERT INTO students (user_id, first_name, last_name, email, date_of_birth) 
            VALUES ('$user_id', '$first_name', '$last_name', '$email', '$date_of_birth')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm sinh viên thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<head>
    <link rel="stylesheet" href="manage_students.css">
</head>
<h2>Thêm sinh viên</h2>
<form method="post">
    <input type="text" name="first_name" placeholder="Họ" required><br>
    <input type="text" name="last_name" placeholder="Tên" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="date" name="date_of_birth" placeholder="Ngày sinh" required><br>
    <button type="submit">Thêm</button>
</form>

<!-- Nút quay về trang chính của Admin -->
<a href="admin_dashboard.php">
    <button>Quay về trang chính</button>
</a>

<h2>Danh sách sinh viên</h2>
<?php
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Họ</th><th>Tên</th><th>Email</th><th>Ngày sinh</th><th>Hành động</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['date_of_birth']}</td>
                <td>
                    <a href='edit_student.php?id={$row['student_id']}'>Sửa</a> | 
                    <a href='delete_student.php?id={$row['student_id']}'>Xóa</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có sinh viên nào.";
}
?>