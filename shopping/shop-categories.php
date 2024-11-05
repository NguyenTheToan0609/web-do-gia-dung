<?php session_start();
include_once('includes/config.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Trang Chủ Cửa Hàng </title>
        <!-- Biểu tượng Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Biểu tượng Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- CSS chủ đề chính (bao gồm Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
       <!--  <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
    </head>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Đầu trang-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Danh Mục Cửa Hàng</h1>
                </div>
            </div>
        </header>
        <!-- Phần nội dung-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
<?php $query=mysqli_query($con,"select category.id as catid,category.categoryName from category ");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?> 

                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Hình ảnh sản phẩm-->
                            <img src="assets/category.png"  alt="<?php echo htmlentities($row['categoryName']);?>" width="150" style="display: block;margin-left: auto; margin-right: auto; width: 40%;" />
                            <!-- Chi tiết sản phẩm-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Tên sản phẩm-->
                                    <h5 class="fw-bolder"><?php echo htmlentities($row['categoryName']);?></h5>
                                    <!-- Giá sản phẩm-->
                                </div>
                            </div>
                            <!-- Hành động sản phẩm-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="categorywise-products.php?cid=<?php echo htmlentities($row['catid']);?>">Xem tùy chọn</a></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
             </div>
            </div>

</div>
        </section>
        <!-- Chân trang-->
   <?php include_once('includes/footer.php'); ?>
        <!-- JS cơ bản của Bootstrap-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- JS chủ đề chính-->
        <script src="js/scripts.js"></script>
    </body>
</html>
