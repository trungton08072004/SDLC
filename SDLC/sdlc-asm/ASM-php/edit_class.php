<?php
include 'db.php';

$id = intval($_GET['id']); // Chuyển đổi id thành số nguyên để tránh lỗi Injection

// Lấy thông tin lớp học cần sửa
$sql = "SELECT * FROM classes WHERE class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();

if (!$class) {
    echo "Lớp học không tồn tại.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    // Kiểm tra xem 'teacher_id' có tồn tại trong $_POST không
    if (isset($_POST['teacher_id'])) {
        $teacher_id = intval($_POST['teacher_id']);
    } else {
        $teacher_id = NULL;  // Nếu không có 'teacher_id', đặt nó là NULL
    }

    // Kiểm tra xem teacher_id có hợp lệ không (giá trị có tồn tại trong bảng teachers)
    if ($teacher_id !== NULL) {
        $teacher_check_query = "SELECT teacher_id FROM teachers WHERE teacher_id = ?";
        $teacher_check_stmt = $conn->prepare($teacher_check_query);
        $teacher_check_stmt->bind_param("i", $teacher_id);
        $teacher_check_stmt->execute();
        $teacher_check_result = $teacher_check_stmt->get_result();

        if ($teacher_check_result->num_rows === 0) {
            echo "Giáo viên không hợp lệ!";
            exit();
        }
    }

    // Cập nhật lớp học vào cơ sở dữ liệu với prepared statements
    $update_sql = "UPDATE classes SET class_name = ?, teacher_id = ? WHERE class_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $name, $teacher_id, $id);

    if ($update_stmt->execute()) {
        echo "Cập nhật lớp học thành công!";
        header('Location: manage_classes.php');
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!-- Form Sửa Lớp Học -->
<h2>Sửa lớp học</h2>
<form method="post">
    <label for="name">Tên lớp:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($class['class_name']); ?>" required><br>

    <label for="teacher_id">Giáo viên:</label>
    <select name="teacher_id">
        <option value="">-- Chọn giáo viên --</option>
        <?php
        // Lấy danh sách giáo viên từ bảng teachers
        $teacher_query = "SELECT teacher_id, first_name, last_name FROM teachers";
        $teachers = $conn->query($teacher_query);

        // Hiển thị danh sách giáo viên và chọn giáo viên hiện tại của lớp
        while ($teacher = $teachers->fetch_assoc()) {
            $selected = ($teacher['teacher_id'] == $class['teacher_id']) ? "selected" : "";
            echo "<option value='{$teacher['teacher_id']}' $selected>{$teacher['first_name']} {$teacher['last_name']}</option>";
        }
        ?>
    </select><br>

    <button type="submit">Cập nhật</button>
</form>