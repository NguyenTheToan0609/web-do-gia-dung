<?php session_start();
include_once('includes/config.php');
if(strlen($_SESSION['id'])==0)
{ header('location:logout.php');
}else{
?>
<!DOCTYPE html>
<html lang="vi">
    <đầu>
        <bộ ký tự meta="utf-8" />
        <meta name="viewport" content="width=device-width, first-scale=1, thu nhỏ để vừa vặn=no" />
        <meta name="description" content="" />
        <meta name="tác giả" nội dung="" />
        <title>Cổng mua sắm | Đơn hàng của tôi</title>
        <!-- Biểu tượng yêu thích-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Biểu tượng Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- CSS chủ đề cốt lõi (bao gồm Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
       <!-- <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
    </head>
<style type="text/css"></style>
    <cơ thể>
<?php include_once('includes/header.php');?>
        <!-- Tiêu đề-->
        <header class="bg-dark py-5">
            <div class="thùng chứa px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Đơn hàng của tôi</h1>
                </div>

            </div>
        </tiêu đề>
        <!-- Phần-->
        <section class="py-5">
            <div class="thùng chứa px-4 mt-5">
     

    <div class="đáp ứng bảng">
        <bảng lớp="bảng">
            <đầu>
                <tr>
                    <th colspan="4"><h4>Đơn đặt hàng của tôi</h4></th>
                </tr>
            </thead>
            <tr>
                <đầu>
                    <th>#</th>
                    <th>Số đơn hàng </th>
                    <th>Ngày đặt hàng</th>
                    <th>Loại giao dịch</th>
                    <th>Tổng số tiền</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Hành động</th>
                </thead>
            </tr>
            <tbody>
<?php
$uid=$_SESSION['id'];
$ret=mysqli_query($con,"select * từ các đơn hàng có userId='$uid'");
$num=mysqli_num_rows($ret);
$cnt=1;
    if($num>0)
    {
while ($row=mysqli_fetch_array($ret)) {

?>

                <tr>
                    <td><?php echo htmlentities($cnt);?></td>
                    <td><?php echo htmlentities($row['orderNumber']);?></td>
                    <td><?php echo htmlentities($row['orderDate']);?></td>
                    <td><?php echo htmlentities($row['txnType']);?></td>
                    <td><?php echo htmlentities($row['totalAmount']);?></td>
                    <td><?php $ostatus=$row['orderStatus'];
                    if( $ostatus==''): echo "Chưa được xử lý";
                        khác: echo $ostus; endif;?><br />
                    </td>
                    <td><a href="order-details.php?onumber=<?php echo htmlentities($row['orderNumber']);?>" class="btn-upper btn btn-primary">Chi tiết</a ></td>
                
                </tr>
            
                <?php $cnt++;} } else{ ?>
                <tr>
                    <td style="font-size: 18px; font-weight:bold ">Chưa đặt hàng. 
<a href="shop-categories.php" class="btn-upper btn btn-warning">Tiếp tục mua sắm</a>
                    </td>

                </tr>
                <?php } ?>
            </tbody>
        </bảng>
    </div>
              
            </div>

 
</div>
        </phần>

        
        <!-- Chân trang-->
   <?php include_once('includes/footer.php'); ?>
        <!-- JS lõi Bootstrap-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Chủ đề cốt lõi JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>