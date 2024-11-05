<?php
session_start(); // Bắt đầu phiên
include('include/config.php'); // Bao gồm file cấu hình
if(strlen($_SESSION['alogin'])==0) { // Kiểm tra xem người dùng đã đăng nhập chưa
    header('location:index.php'); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị viên | Nhật ký người dùng</title> <!-- Tiêu đề trang -->
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap -->
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap phản hồi -->
    <link type="text/css" href="css/theme.css" rel="stylesheet"> <!-- Liên kết đến CSS chủ đề -->
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet"> <!-- Liên kết đến CSS Font Awesome -->
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'> <!-- Liên kết đến font chữ -->
</head>
<body>
<?php include('include/header.php');?> <!-- Bao gồm phần đầu trang -->

<div class="wrapper">
    <div class="container">
        <div class="row">
<?php include('include/sidebar.php');?> <!-- Bao gồm thanh bên -->
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Quản lý người dùng</h3> <!-- Tiêu đề phần -->
                        </div>
                        <div class="module-body table">

                            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th> <!-- Thứ tự -->
                                        <th>Email người dùng</th> <!-- Email người dùng -->
                                        <th>IP người dùng</th> <!-- IP người dùng -->
                                        <th>Thời gian đăng nhập</th> <!-- Thời gian đăng nhập -->
                                        <th>Thời gian đăng xuất</th> <!-- Thời gian đăng xuất -->
                                        <th>Trạng thái</th> <!-- Trạng thái -->
                                    </tr>
                                </thead>
                                <tbody>

<?php 
$query = mysqli_query($con, "SELECT * FROM userlog"); // Lấy nhật ký người dùng
$cnt = 1; // Biến đếm
while($row = mysqli_fetch_array($query)) { // Duyệt qua từng hàng dữ liệu
?>                                  
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td> <!-- Hiển thị thứ tự -->
                                        <td><?php echo htmlentities($row['userEmail']);?></td> <!-- Hiển thị email người dùng -->
                                        <td><?php echo htmlentities($row['userip']);?></td> <!-- Hiển thị IP người dùng -->
                                        <td><?php echo htmlentities($row['loginTime']);?></td> <!-- Hiển thị thời gian đăng nhập -->
                                        <td><?php echo htmlentities($row['logout']); ?></td> <!-- Hiển thị thời gian đăng xuất -->
                                        <td><?php 
                                            $st = $row['status']; // Lấy trạng thái
                                            if($st == 1) {
                                                echo "Thành công"; // Nếu trạng thái là 1, hiển thị "Thành công"
                                            } else {
                                                echo "Thất bại"; // Nếu không, hiển thị "Thất bại"
                                            }
                                        ?></td>
                                    </tr>
<?php 
$cnt = $cnt + 1; // Tăng biến đếm lên 1
} 
?>  
                                </table>
                            </div>
                        </div>                        
                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->

<?php include('include/footer.php');?> <!-- Bao gồm phần chân trang -->

    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script> <!-- Liên kết đến jQuery -->
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script> <!-- Liên kết đến jQuery UI -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script> <!-- Liên kết đến Bootstrap -->
    <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script> <!-- Liên kết đến Flot -->
    <script src="scripts/datatables/jquery.dataTables.js"></script> <!-- Liên kết đến DataTables -->
    <script>
        $(document).ready(function() { // Khi tài liệu đã sẵn sàng
            $('.datatable-1').dataTable(); // Khởi tạo bảng dữ liệu
            $('.dataTables_paginate').addClass("btn-group datatable-pagination"); // Thêm lớp cho phân trang
            $('.dataTables_paginate > a').wrapInner('<span />'); // Bọc các liên kết phân trang
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>'); // Thêm biểu tượng mũi tên trái
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>'); // Thêm biểu tượng mũi tên phải
        });
    </script>
</body>
<?php } ?>
