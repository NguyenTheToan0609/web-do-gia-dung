<?php
session_start(); // Bắt đầu phiên
include('include/config.php'); // Bao gồm file cấu hình
if(strlen($_SESSION['alogin'])==0) // Kiểm tra xem phiên đã được thiết lập chưa
{	
    header('location:index.php'); // Chuyển hướng đến trang đăng nhập nếu không
}
else {
    date_default_timezone_set('Asia/Kolkata'); // Đặt múi giờ theo khu vực
    $currentTime = date('d-m-Y h:i:s A', time()); // Lấy thời gian hiện tại

    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from products where id = '" . $_GET['id'] . "'"); // Thực hiện truy vấn xóa sản phẩm
        $_SESSION['delmsg'] = "Sản phẩm đã bị xóa !!"; // Thông báo đã xóa sản phẩm
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị viên | Quản lý người dùng</title> <!-- Tiêu đề trang -->
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>
<?php include('include/header.php'); ?> <!-- Bao gồm header -->

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php'); ?> <!-- Bao gồm sidebar -->
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Quản lý người dùng</h3> <!-- Tiêu đề module -->
                        </div>
                        <div class="module-body table">
                            <?php if (isset($_GET['del'])) { ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Ôi không!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            <?php } ?>

                            <br />

                            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ giao hàng/Thành phố/Tiểu bang/Mã bưu điện</th>
                                        <th>Địa chỉ thanh toán/Thành phố/Tiểu bang/Mã bưu điện</th>
                                        <th>Ngày đăng ký</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                $query = mysqli_query($con, "select * from users"); // Truy vấn để lấy thông tin người dùng
                                $cnt = 1; // Khởi tạo biến đếm
                                while ($row = mysqli_fetch_array($query)) { 
                                ?>	
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row['name']); ?></td>
                                        <td><?php echo htmlentities($row['email']); ?></td>
                                        <td><?php echo htmlentities($row['contactno']); ?></td>
                                        <td><?php echo htmlentities($row['shippingAddress'] . "," . $row['shippingCity'] . "," . $row['shippingState'] . "-" . $row['shippingPincode']); ?></td>
                                        <td><?php echo htmlentities($row['billingAddress'] . "," . $row['billingCity'] . "," . $row['billingState'] . "-" . $row['billingPincode']); ?></td>
                                        <td><?php echo htmlentities($row['regDate']); ?></td>
                                    </tr>
                                <?php $cnt = $cnt + 1; } ?>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>						
                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php'); ?> <!-- Bao gồm footer -->

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable(); // Khởi tạo bảng dữ liệu
        $('.dataTables_paginate').addClass("btn-group datatable-pagination");
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
    });
</script>
</body>
<?php } ?>
