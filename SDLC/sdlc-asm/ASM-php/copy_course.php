<?php
include 'db.php';

// Lấy ID khóa học từ URL
if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']); // Chuyển đổi ID thành kiểu số nguyên để tránh lỗi

    // Lấy thông tin khóa học từ cơ sở dữ liệu
    $sql = "SELECT * FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id); // Binding ID vào câu lệnh truy vấn

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['course_name'];
        $description = $row['course_description'];

        // Sao chép khóa học và thêm vào cơ sở dữ liệu
        $sql_copy = "INSERT INTO courses (course_name, course_description) VALUES (?, ?)";
        $copy_stmt = $conn->prepare($sql_copy);
        $copy_stmt->bind_param("ss", $name, $description); // Binding name và description vào câu lệnh

        if ($copy_stmt->execute()) {
            echo "Sao chép khóa học thành công!";
        } else {
            echo "Lỗi sao chép khóa học: " . $conn->error;
        }
    } else {
        echo "Khóa học không tồn tại.";
    }
}
?>