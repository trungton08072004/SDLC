<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];

    // Thêm khóa học vào cơ sở dữ liệu
    $sql = "INSERT INTO courses (course_name, course_description) VALUES ('$course_name', '$course_description')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm khóa học thành công!";
        header('Location: manage_classes.php');
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!-- Form Thêm khóa học -->
<form method="post">
    <label for="course_name">Tên khóa học:</label>
    <input type="text" name="course_name" required><br>

    <label for="course_description">Mô tả:</label>
    <textarea name="course_description" required></textarea><br>

    <button type="submit">Thêm</button>
</form>