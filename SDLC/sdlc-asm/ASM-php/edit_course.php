<?php
include 'db.php';

// Lấy ID khóa học từ URL
if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']); // Đảm bảo rằng ID là một số nguyên hợp lệ

    // Lấy thông tin khóa học từ cơ sở dữ liệu
    $sql = "SELECT * FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $course_name = $row['course_name'];
        $course_description = $row['course_description'];
    } else {
        echo "Khóa học không tồn tại.";
        exit;
    }
}

// Xử lý form khi người dùng gửi dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];

    // Cập nhật thông tin khóa học
    $sql_update = "UPDATE courses SET course_name = ?, course_description = ? WHERE course_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $course_name, $course_description, $course_id);

    if ($stmt_update->execute()) {
        echo "Cập nhật khóa học thành công!";
        header('Location: manage_courses.php');
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<head>
    <link rel="stylesheet" href="edit_courses.css">
</head>

<!-- Form chỉnh sửa khóa học -->
<h2>Chỉnh sửa khóa học</h2>
<form method="post">
    <label for="course_name">Tên khóa học:</label>
    <input type="text" name="course_name" value="<?php echo htmlspecialchars($course_name); ?>" required><br>

    <label for="course_description">Mô tả:</label>
    <textarea name="course_description" required><?php echo htmlspecialchars($course_description); ?></textarea><br>

    <button type="submit">Cập nhật</button>
</form>