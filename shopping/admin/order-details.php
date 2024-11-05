<?php
session_start(); // Bắt đầu phiên
include('include/config.php'); // Bao gồm file cấu hình
if (strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php'); // Chuyển hướng đến trang chính nếu không có phiên
} else {
    date_default_timezone_set('Asia/Kolkata'); // Thay đổi theo múi giờ
    $currentTime = date('d-m-Y h:i:s A', time()); // Lấy thời gian hiện tại
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Đơn hàng đang chờ</title> <!-- Tiêu đề trang -->
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <script language="javascript" type="text/javascript">
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>
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
                                <h3>Chi tiết đơn hàng #<?php echo intval($_GET['oid']); ?></h3> <!-- Tiêu đề chi tiết đơn hàng -->
                            </div>
                            <div class="module-body table">
                                <br />
                                <div class="table-responsive">		
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display table-responsive">
                                        <tbody>
                                            <?php 
                                            $orderid = intval($_GET['oid']);
                                            $query = mysqli_query($con, "SELECT orders.id AS oid, users.name AS username, users.email AS useremail, users.contactno AS usercontact, users.shippingAddress AS shippingaddress, users.shippingCity AS shippingcity, users.shippingState AS shippingstate, users.shippingPincode AS shippingpincode, products.productName AS productname, products.shippingCharge AS shippingcharge, orders.quantity AS quantity, orders.orderDate AS orderdate, products.productPrice AS productprice, billingAddress, billingState, billingCity, billingPincode, products.id AS pid, productImage1, shippingcharge FROM orders JOIN users ON orders.userId = users.id JOIN products ON products.id = orders.productId WHERE orders.id='$orderid'");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>										
                                                <tr>
                                                    <th>Mã đơn hàng</th>
                                                    <td><?php echo htmlentities($row['oid']); ?></td>
                                                    <th>Ngày đặt hàng</th>
                                                    <td><?php echo htmlentities($row['orderdate']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tên người dùng</th>
                                                    <td><?php echo htmlentities($row['username']); ?></td>
                                                    <th>Thông tin liên lạc của người dùng</th>
                                                    <td><?php echo htmlentities($row['useremail']); ?>/<?php echo htmlentities($row['usercontact']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Thông tin giao hàng của người dùng</th>
                                                    <td><?php echo htmlentities($row['billingAddress'] . "," . $row['billingCity'] . "," . $row['billingState'] . "-" . $row['shippingpincode']); ?></td>
                                                    <th>Thông tin thanh toán của người dùng</th>
                                                    <td><?php echo htmlentities($row['shippingaddress'] . "," . $row['shippingcity'] . "," . $row['shippingstate'] . "-" . $row['billingPincode']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tên sản phẩm</th>
                                                    <td><?php echo htmlentities($row['productname']); ?></td>
                                                    <th>Hình ảnh sản phẩm</th>
                                                    <td><img src="productimages/<?php echo htmlentities($row['pid'] . "/" . $row['productImage1']); ?>" width="100"></td>
                                                </tr>
                                                <tr>
                                                    <th>Số lượng sản phẩm</th>
                                                    <td><?php echo htmlentities($row['quantity']); ?></td>
                                                    <th>Giá sản phẩm</th>
                                                    <td><?php echo htmlentities($row['productprice']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Phí vận chuyển</th>
                                                    <td><?php echo htmlentities($row['shippingcharge']); ?></td>
                                                    <th>Tổng cộng</th>
                                                    <td><?php echo htmlentities($row['quantity'] * $row['productprice'] + $row['shippingcharge']); ?></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                    <?php $cnt = $cnt + 1; } ?>
                                    
                                    <?php 
                                    $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$orderid'");
                                    $count = mysqli_num_rows($ret);
                                    ?>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" style="margin-top:1%;">
                                    <?php if ($count > 0) { ?>
                                        <tr>
                                            <th colspan="4" style="color:blue; font-size:16px; text-align:center;">Lịch sử đơn hàng</th>
                                        </tr>
                                        <tr>
                                            <th>Ghi chú</th>
                                            <th>Tình trạng</th>
                                            <th>Ngày</th>
                                        </tr>
                                        <?php while ($row = mysqli_fetch_array($ret)) { ?>
                                            <tr>
                                                <td><?php echo $row['remark']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['postingDate']; ?></td>
                                            </tr>
                                        <?php } } ?>
                                        
                                        <tr>
                                            <td colspan="4">
                                                <a href="updateorder.php?oid=<?php echo htmlentities($orderid); ?>" title="Cập nhật đơn hàng" target="_blank" class="btn btn-primary">Thực hiện hành động</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
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
            $('.datatable-1').dataTable();
            $('.dataTables_paginate').addClass("btn-group datatable-pagination");
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        });
    </script>
</body>
<?php } ?>
