<?php
include 'db.php';

// Kiểm tra nếu có tham số 'id' trong URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn xóa giáo viên từ cơ sở dữ liệu
    $sql_delete = "DELETE FROM teachers WHERE teacher_id = '$id'";

    if ($conn->query($sql_delete) === TRUE) {
        echo "Xóa giáo viên thành công!";
        header('Location: manage_teachers.php'); // Quay lại trang quản lý giáo viên
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "ID không hợp lệ.";
    exit();
}
