<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $course_id = intval($_POST['course_id']); // Chuyển đổi giá trị thành số nguyên

    // Kiểm tra xem course_id có tồn tại trong bảng courses không
    $checkCourse = "SELECT * FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($checkCourse);
    $stmt->bind_param("i", $course_id); // Bảo vệ khỏi SQL Injection
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra kết quả truy vấn
    if ($result->num_rows > 0) {
        // Nếu course_id tồn tại trong bảng courses, thêm vào bảng classes
        $sql = "INSERT INTO classes (class_name, course_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $course_id); // Bảo vệ khỏi SQL Injection

        if ($stmt->execute()) {
            echo "Thêm lớp học thành công!";
            header('Location: manage_classes.php');
            exit();
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        echo "Lỗi: Mã khóa học không tồn tại. Vui lòng chọn mã hợp lệ.";
    }
}
?>

<!-- Form Thêm Lớp Học -->
<h2>Thêm lớp học mới</h2>

<head>
    <link rel="stylesheet" href="add_class.css">
</head>

<form method="post">
    <label for="name">Tên lớp:</label>
    <input type="text" name="name" required><br>

    <label for="course_id">Mã khóa học:</label>
    <select name="course_id" required>
        <option value="">-- Chọn khóa học --</option>
        <?php
        $course_query = "SELECT course_id, course_name FROM courses";
        $courses = $conn->query($course_query);

        while ($course = $courses->fetch_assoc()) {
            echo "<option value='{$course['course_id']}'>{$course['course_name']}</option>";
        }
        ?>
    </select><br>

    <button type="submit">Thêm</button>
</form>