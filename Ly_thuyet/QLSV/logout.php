<?php
// Bắt đầu session
session_start();

// Hủy tất cả các session
session_unset();

// Hủy bỏ session hiện tại
session_destroy();

// Chuyển hướng đến trang đăng nhập
header("Location: Login.php");
exit();
?>
