<?php
include 'db.php';

// Lấy ID sinh viên từ URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Lấy thông tin sinh viên từ cơ sở dữ liệu
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";  // Dùng 'student_id' thay vì 'id'
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $date_of_birth = $row['date_of_birth'];
    } else {
        echo "Sinh viên không tồn tại.";
        exit;
    }
}

// Xử lý form khi người dùng gửi dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];

    // Cập nhật thông tin sinh viên
    $sql_update = "UPDATE students 
                   SET first_name = '$first_name', last_name = '$last_name', email = '$email', date_of_birth = '$date_of_birth' 
                   WHERE student_id = '$student_id'";  // Sử dụng 'student_id'

    if ($conn->query($sql_update) === TRUE) {
        // Sau khi cập nhật thành công, chuyển hướng về trang quản lý sinh viên
        header("Location: manage_students.php");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!-- Form chỉnh sửa thông tin sinh viên -->
<h2>Chỉnh sửa thông tin sinh viên</h2>
<form method="post">
    <label for="first_name">Tên:</label>
    <input type="text" name="first_name" value="<?php echo $first_name; ?>" required><br>

    <label for="last_name">Họ:</label>
    <input type="text" name="last_name" value="<?php echo $last_name; ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $email; ?>" required><br>

    <label for="date_of_birth">Ngày sinh:</label>
    <input type="date" name="date_of_birth" value="<?php echo $date_of_birth; ?>" required><br>

    <button type="submit">Cập nhật</button>
</form>