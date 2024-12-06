<?php
include 'db.php';

// Lấy ID khóa học từ URL
if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']); // Chuyển đổi ID thành kiểu số nguyên

    // Sử dụng Prepared Statement để xóa khóa học
    $sql_delete = "DELETE FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        echo "Khóa học đã được xóa thành công!";
        header('Location: manage_classes.php');
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>