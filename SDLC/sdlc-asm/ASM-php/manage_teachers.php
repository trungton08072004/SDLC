<?php
include 'db.php';

echo "<h2>Quản lý giáo viên</h2>";

// Thêm giáo viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];

    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    $sql_check_email = "SELECT * FROM teachers WHERE email = '$email'";
    $result_check = $conn->query($sql_check_email);

    if ($result_check->num_rows > 0) {
        echo "Lỗi: Email này đã được sử dụng. Vui lòng sử dụng email khác.";
    } else {
        // Thêm giáo viên vào cơ sở dữ liệu
        $sql = "INSERT INTO teachers (first_name, last_name, email, department) 
                VALUES ('$first_name', '$last_name', '$email', '$department')";

        if ($conn->query($sql) === TRUE) {
            echo "Thêm giáo viên thành công!";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}
?>

<head>
    <link rel="stylesheet" href="manage_teachers.css">
</head>


<!-- Form Thêm Giáo Viên -->
<form method="post">
    <input type="text" name="first_name" placeholder="Tên" required><br>
    <input type="text" name="last_name" placeholder="Họ" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="department" placeholder="Khoa"><br>
    <button type="submit">Thêm</button>
</form>

<!-- Nút quay về trang admin -->
<a href="admin_dashboard.php"><button>Quay về trang Admin</button></a>

<!-- Danh sách giáo viên -->
<h3>Danh sách giáo viên</h3>
<?php
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Tên</th><th>Email</th><th>Khoa</th><th>Hành động</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['teacher_id']}</td>
                <td>{$row['first_name']} {$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['department']}</td>
                <td>
                    <a href='edit_teacher.php?id={$row['teacher_id']}'>Sửa</a> | 
                    <a href='delete_teacher.php?id={$row['teacher_id']}'>Xóa</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có giáo viên nào.";
}
?>