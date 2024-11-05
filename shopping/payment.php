<?php 
session_start();
include_once('includes/config.php');
if(strlen($_SESSION['id'])==0)
{   
    header('location:logout.php');
}
else {
    if($_SESSION['address'] == 0):
        echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
    endif;    

    // Chi tiết đơn hàng
    if(isset($_POST['submit'])) {
        $orderno = mt_rand(100000000, 999999999);
        $userid = $_SESSION['id'];
        $address = $_SESSION['address'];
        $totalamount = $_SESSION['gtotal'];
        $txntype = $_POST['paymenttype'];
        $txnno = $_POST['txnnumber'];

        $query = mysqli_query($con, "insert into orders(orderNumber, userId, addressId, totalAmount, txnType, txnNumber) values('$orderno', '$userid', '$address', '$totalamount', '$txntype', '$txnno')");

        if($query) {
            $sql = "insert into ordersdetails (userId, productId, quantity) select userID, productId, productQty from cart where userID='$userid';";
            $sql .= "update ordersdetails set orderNumber='$orderno' where userId='$userid' and orderNumber is null;";
            $sql .= "delete from cart where userID='$userid'";
            $result = mysqli_multi_query($con, $sql);
            if ($result) {
                unset($_SESSION['address']);
                unset($_SESSION['gtotal']);    
                echo '<script>alert("Đơn hàng của bạn đã được đặt thành công. Số đơn hàng là: ' . $orderno . '")</script>';
                echo "<script type='text/javascript'> document.location ='my-orders.php'; </script>";
            } 
        } else {
            echo "<script>alert('Có gì đó không ổn. Vui lòng thử lại');</script>";
            echo "<script type='text/javascript'> document.location ='payment.php'; </script>";
        } 
    }
?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Mua sắm | Thanh toán</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Biểu tượng Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- CSS chủ đề (bao gồm Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
        <!--  <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
    </head>
    <style type="text/css"></style>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Thanh toán</h1>
                </div>
            </div>
        </header>
        <!-- Phần-->
        <section class="py-5">
            <div class="container px-4 mt-5">
                <form method="post" name="signup">
                    <div class="row">
                        <div class="col-2">Tổng số tiền</div>
                        <div class="col-6"><input type="text" name="totalamount" value="<?php echo  $_SESSION['gtotal'];?>" class="form-control" readonly ></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-2">Loại thanh toán</div>
                        <div class="col-6">
                            <select class="form-control" name="paymenttype" id="paymenttype" required>
                                <option value="">Chọn</option>
                                <option value="e-Wallet">Ví điện tử</option>
                                <option value="Internet Banking">Ngân hàng trực tuyến</option>
                                <option value="Debit/Credit Card">Thẻ ghi nợ / Thẻ tín dụng</option>
                                <option value="Cash on Delivery">Giao hàng thu tiền (COD)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3" id="txnno">
                        <div class="col-2">Số giao dịch</div>
                        <div class="col-6"><input type="text" name="txnnumber" id="txnnumber" class="form-control" maxlength="50"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">&nbsp;</div>
                        <div class="col-6"><input type="submit" name="submit" id="submit" class="btn btn-primary" required></div>
                    </div>
                </form>
            </div>
        </section>
        <!-- Chân trang-->
        <?php include_once('includes/footer.php'); ?>
        <!-- JS core Bootstrap-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- JS chủ đề-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<script type="text/javascript">
  // Để tạo báo cáo
  $('#txnno').hide();
  $(document).ready(function(){
      $('#paymenttype').change(function(){
          if($('#paymenttype').val() == 'Cash on Delivery') {
              $('#txnno').hide();
          } else if($('#paymenttype').val() == '') {
              $('#txnno').hide();
          } else {
              $('#txnno').show();
              jQuery("#txnnumber").prop('required', true);  
          }
      });
  }); 
</script>
<?php } ?>
