<?php
include 'db.php';

// Lấy và kiểm tra ID từ tham số GET
$class_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($class_id <= 0) {
    echo "ID không hợp lệ.";
    exit();
}

// Sử dụng Prepared Statement để xóa lớp học
$sql = "DELETE FROM classes WHERE class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $class_id);

if ($stmt->execute()) {
    echo "Xóa lớp học thành công!";
    header('Location: manage_classes.php');
    exit();
} else {
    echo "Lỗi: " . $conn->error;
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>