<?php
// Bắt đầu session với thời gian tồn tại là 1 năm (tính bằng giây)
$lifetime = 60 * 60 * 24 * 365; // 1 năm = 365 ngày
session_set_cookie_params($lifetime, '/');
session_start();

// Lấy danh sách task từ Session (nếu chưa có thì tạo mảng rỗng)
if (isset($_SESSION['tasklist'])) {
    $task_list = $_SESSION['tasklist'];
} else {
    $task_list = array();
}

$errors = array();

// Kiểm tra xem có gửi action lên không để tránh lỗi Warning lần đầu load trang
$action = '';
if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch( $action ) {
    case 'add':
        $new_task = $_POST['newtask'];
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
            $task_list[] = $new_task;
        }
        break;
    case 'delete':
        $task_index = $_POST['taskid'];
        unset($task_list[$task_index]);
        $task_list = array_values($task_list); // Sắp xếp lại index cho mảng
        break;
}

// Lưu mảng task_list mới cập nhật trở lại vào Session
$_SESSION['tasklist'] = $task_list;

include('task_list.php');
?>