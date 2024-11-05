<?php
session_start(); // Bắt đầu phiên
include('include/config.php'); // Bao gồm file cấu hình
if(strlen($_SESSION['alogin'])==0) { // Kiểm tra xem người dùng đã đăng nhập hay chưa
    header('location:index.php'); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
} else {
    date_default_timezone_set('Asia/Kolkata'); // Thay đổi theo múi giờ
    $currentTime = date('d-m-Y h:i:s A', time()); // Lấy thời gian hiện tại
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị | Đơn hàng hôm nay</title> <!-- Tiêu đề trang -->
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap -->
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap đáp ứng -->
    <link type="text/css" href="css/theme.css" rel="stylesheet"> <!-- Liên kết đến CSS chủ đề -->
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet"> <!-- Liên kết đến CSS Font Awesome -->
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'> <!-- Liên kết đến font -->
    <script language="javascript" type="text/javascript">
        var popUpWin=0; // Biến để lưu cửa sổ pop-up
        function popUpWindow(URLStr, left, top, width, height) { // Hàm mở cửa sổ pop-up
            if(popUpWin) {
                if(!popUpWin.closed) popUpWin.close(); // Đóng cửa sổ nếu đang mở
            }
            popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
        }
    </script>
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
                            <h3>Đơn hàng hôm nay</h3> <!-- Tiêu đề chính -->
                        </div>
                        <div class="module-body table">
                            <?php if(isset($_GET['del'])) { ?> <!-- Kiểm tra nếu có thông báo xóa -->
                                <div class="alert alert-error"> <!-- Thông báo lỗi -->
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Ôi không!</strong> <?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
                                </div>
                            <?php } ?>

                            <br />

                            <div class="table-responsive">		
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên</th>
                                            <th width="50">Email / SĐT</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
<?php 
$f1 = "00:00:00"; // Giờ bắt đầu
$from = date('Y-m-d')." ".$f1; // Lấy ngày hiện tại từ 00:00:00
$t1 = "23:59:59"; // Giờ kết thúc
$to = date('Y-m-d')." ".$t1; // Lấy ngày hiện tại đến 23:59:59
$query = mysqli_query($con,"SELECT users.name AS username, users.email AS useremail, users.contactno AS usercontact, users.shippingAddress AS shippingaddress, users.shippingCity AS shippingcity, users.shippingState AS shippingstate, users.shippingPincode AS shippingpincode, products.productName AS productname, products.shippingCharge AS shippingcharge, orders.quantity AS quantity, orders.orderDate AS orderdate, products.productPrice AS productprice, orders.id AS id FROM orders JOIN users ON orders.userId = users.id JOIN products ON products.id = orders.productId WHERE orders.orderDate BETWEEN '$from' AND '$to'"); // Lấy đơn hàng trong ngày
$cnt = 1;
while($row = mysqli_fetch_array($query)) { // Duyệt qua từng đơn hàng
?>										
                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td> <!-- Số thứ tự -->
                                            <td><?php echo htmlentities($row['username']);?></td> <!-- Tên người dùng -->
                                            <td><?php echo htmlentities($row['useremail']);?>/<?php echo htmlentities($row['usercontact']);?></td> <!-- Email và SĐT -->
                                            <td><?php echo htmlentities($row['productname']);?></td> <!-- Tên sản phẩm -->
                                            <td><?php echo htmlentities($row['orderdate']);?></td> <!-- Ngày đặt hàng -->
                                            <td>
                                                <a href="order-details.php?oid=<?php echo htmlentities($row['id']);?>" title="Chi tiết đơn hàng" target="_blank" class="btn btn-info">Chi tiết</a> <!-- Nút xem chi tiết đơn hàng -->
                                            </td>
                                        </tr>
<?php $cnt = $cnt + 1; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>						
                    </div><!--/.module-->						
                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php');?> <!-- Bao gồm phần chân trang -->

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script> <!-- Liên kết đến JS jQuery -->
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script> <!-- Liên kết đến JS jQuery UI -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script> <!-- Liên kết đến JS Bootstrap -->
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script> <!-- Liên kết đến JS Flot -->
<script src="scripts/datatables/jquery.dataTables.js"></script> <!-- Liên kết đến JS DataTables -->
<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable(); // Khởi tạo DataTable
        $('.dataTables_paginate').addClass("btn-group datatable-pagination"); // Thêm lớp cho phân trang
        $('.dataTables_paginate > a').wrapInner('<span />'); // Bọc nội dung phân trang
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>'); // Thêm biểu tượng mũi tên trái
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>'); // Thêm biểu tượng mũi tên phải
    });
</script>
</body>
<?php } ?>
