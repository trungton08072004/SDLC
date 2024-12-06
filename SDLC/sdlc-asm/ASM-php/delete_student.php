<?php
include 'db.php';

// Lấy ID sinh viên từ URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Xóa sinh viên khỏi cơ sở dữ liệu
    $sql_delete = "DELETE FROM students WHERE student_id = '$student_id'";  // Thay 'id' thành 'student_id'

    if ($conn->query($sql_delete) === TRUE) {
        // Sau khi xóa thành công, chuyển hướng về trang quản lý sinh viên
        header("Location: manage_students.php");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>