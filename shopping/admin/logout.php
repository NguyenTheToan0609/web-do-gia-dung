<?php
session_start(); // Bắt đầu phiên
$_SESSION['alogin']==""; // Đặt giá trị của biến session 'alogin' thành rỗng
session_unset(); // Giải phóng tất cả các biến phiên
//session_destroy(); // Hủy phiên (được bình luận lại)
$_SESSION['errmsg']="Bạn đã đăng xuất thành công"; // Thiết lập thông báo cho biến session 'errmsg'
?>
<script language="javascript">
document.location="index.php"; // Chuyển hướng đến trang index.php
</script>
