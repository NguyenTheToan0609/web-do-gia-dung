<?php
session_start(); // Bắt đầu phiên
include('include/config.php'); // Bao gồm file cấu hình
if(strlen($_SESSION['alogin'])==0) { // Kiểm tra xem người dùng đã đăng nhập chưa
    header('location:index.php'); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
} else {
    date_default_timezone_set('Asia/Kolkata'); // Thiết lập múi giờ
    $currentTime = date('d-m-Y h:i:s A', time()); // Lấy thời gian hiện tại
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị | Đơn hàng đang chờ xử lý</title> <!-- Tiêu đề trang -->
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- Thư viện Bootstrap -->
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> <!-- Thư viện Bootstrap Responsive -->
    <link type="text/css" href="css/theme.css" rel="stylesheet"> <!-- Tập tin CSS cho giao diện -->
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet"> <!-- Font Awesome cho biểu tượng -->
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'> <!-- Tải font chữ -->
    <script language="javascript" type="text/javascript">
        var popUpWin = 0; // Khởi tạo biến cửa sổ popup
        function popUpWindow(URLStr, left, top, width, height) { // Hàm mở cửa sổ popup
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close(); // Đóng cửa sổ nếu đã mở
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ',top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>
</head>
<body>
<?php include('include/header.php'); ?> <!-- Bao gồm phần đầu trang -->

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php'); ?> <!-- Bao gồm thanh bên -->
            <div class="span9">
                <div class="content">
                    <div class="module">
                        <div class="module-head">
                            <h3>Đơn hàng đang chờ xử lý</h3> <!-- Tiêu đề module -->
                        </div>
                        <div class="module-body table">
                            <?php if(isset($_GET['del'])) { ?>
                                <div class="alert alert-error"> <!-- Thông báo lỗi khi xóa -->
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            <?php } ?>
                            <br />
                            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th width="50">Email / Số điện thoại</th>
                                        <th>Sản phẩm</th>
                                        <th>Ngày đặt hàng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $status = 'Delivered'; // Trạng thái đơn hàng
                                $query = mysqli_query($con, "SELECT users.name as username, users.email as useremail, users.contactno as usercontact, users.shippingAddress as shippingaddress, users.shippingCity as shippingcity, users.shippingState as shippingstate, users.shippingPincode as shippingpincode, products.productName as productname, products.shippingCharge as shippingcharge, orders.quantity as quantity, orders.orderDate as orderdate, products.productPrice as productprice, orders.id as id FROM orders JOIN users ON orders.userId = users.id JOIN products ON products.id = orders.productId WHERE orders.orderStatus != '$status' OR orders.orderStatus IS NULL"); // Truy vấn đơn hàng
                                $cnt = 1; // Biến đếm
                                while($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td> <!-- Số thứ tự -->
                                        <td><?php echo htmlentities($row['username']); ?></td> <!-- Tên người dùng -->
                                        <td><?php echo htmlentities($row['useremail']); ?> / <?php echo htmlentities($row['usercontact']); ?></td> <!-- Email và số điện thoại -->
                                        <td><?php echo htmlentities($row['productname']); ?></td> <!-- Tên sản phẩm -->
                                        <td><?php echo htmlentities($row['orderdate']); ?></td> <!-- Ngày đặt hàng -->
                                        <td>
                                            <a href="order-details.php?oid=<?php echo htmlentities($row['id']); ?>" title="Chi tiết đơn hàng" target="blank" class="btn btn-info">Chi tiết</a> <!-- Nút xem chi tiết đơn hàng -->
                                        </td>
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

<?php include('include/footer.php'); ?> <!-- Bao gồm phần chân trang -->

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable(); // Khởi tạo DataTable
        $('.dataTables_paginate').addClass("btn-group datatable-pagination"); // Thêm class cho phân trang
        $('.dataTables_paginate > a').wrapInner('<span />'); // Bọc nội dung phân trang
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>'); // Thêm biểu tượng cho phân trang trái
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>'); // Thêm biểu tượng cho phân trang phải
    });
</script>
</body>
<?php } ?>
