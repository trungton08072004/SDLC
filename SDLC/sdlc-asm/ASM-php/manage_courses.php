<?php
include 'db.php';

echo "<h2>Danh sách khóa học</h2>";

// Truy vấn lấy dữ liệu các khóa học
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Tên khóa học</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>";

    // Lặp qua các kết quả và hiển thị trong bảng
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['course_id']}</td>
                <td>{$row['course_name']}</td>
                <td>{$row['course_description']}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <a href='edit_course.php?id={$row['course_id']}'>Sửa</a> | 
                    <a href='copy_course.php?id={$row['course_id']}'>Sao chép</a> | 
                    <a href='delete_course.php?id={$row['course_id']}'>Xóa</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu khóa học nào.";
}
?>

<head>
    <link rel="stylesheet" href="manage_courses.css">

</head>

<!-- Liên kết thêm khóa học -->
<a href="add_course.php">Thêm khóa học mới</a><br><br>

<!-- Nút quay về trang chính của Admin -->
<a href="admin_dashboard.php">
    <button>Quay về trang chính</button>
</a>