<?php 

if(isset($_GET['action'])) {
    if(!empty($_SESSION['cart'])) {
        foreach($_POST['quantity'] as $key => $val) {
            if($val == 0) {
                unset($_SESSION['cart'][$key]);
            } else {
                $_SESSION['cart'][$key]['quantity'] = $val;
            }
        }
    }
}
?>
<div class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3  logo-holder">
                <div class="logo">
                    <a href="index.php">
					<h2 style="margin-top: 8px; margin-bottom: 15px;">Cổng Mua Sắm</h2>

                    </a>
                </div>        
            </div>
			<div class="col-xs-12 col-sm-12 col-md-6">
    <style>
        .search-area {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .search-area form {
            display: flex;
            width: 100%;
            max-width: 600px;
        }

        .search-field {
            flex-grow: 1;
            padding: 12px 20px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .search-button {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            font-size: 16px;
			margin-left: 10px;
        }

        .search-button:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="search-area">
        <form name="search" method="post" action="search-result.php">
            <input class="search-field" placeholder="Tìm kiếm ở đây..." name="product" required="required" />
            <button class="search-button" type="submit" name="search">Tìm kiếm</button>
        </form>
    </div>
</div>


            <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
                <?php
                if(!empty($_SESSION['cart'])) {
                    ?>
                    <div class="dropdown dropdown-cart">
                        <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                            <div class="items-cart-inner">
                                <div class="total-price-basket">
                                    <span class="lbl">giỏ hàng -</span>
                                    <span class="total-price">
                                        <span class="sign"></span>
                                        <span class="value"><?php echo $_SESSION['tp']; ?></span>
                                    </span>
                                </div>
                                <div class="basket">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </div>
                                <div class="basket-item-count"><span class="count"><?php echo $_SESSION['qnty'];?></span></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            $sql = "SELECT * FROM products WHERE id IN(";
                            foreach($_SESSION['cart'] as $id => $value) {
                                $sql .= $id . ",";
                            }
                            $sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
                            $query = mysqli_query($con, $sql);
                            $totalprice = 0;
                            $totalqunty = 0;
                            if(!empty($query)) {
                                while($row = mysqli_fetch_array($query)) {
                                    $quantity = $_SESSION['cart'][$row['id']]['quantity'];
                                    $subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge'];
                                    $totalprice += $subtotal;
                                    $_SESSION['qnty'] = $totalqunty += $quantity;
                            ?>
                            <li>
                                <div class="cart-item product-summary">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="image">
                                                <a href="product-details.php?pid=<?php echo $row['id'];?>"><img src="admin/productimages/<?php echo $row['id'];?>/<?php echo $row['productImage1'];?>" width="35" height="50" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="col-xs-7">
                                            <h3 class="name"><a href="product-details.php?pid=<?php echo $row['id'];?>"><?php echo $row['productName']; ?></a></h3>
                                            <div class="price"><?php echo ($row['productPrice'] + $row['shippingCharge']); ?>$*<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?></div>
                                        </div>
                                    </div>
                                </div><!-- /.cart-item -->
                            <?php 
                                } 
                            } 
                            ?>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="clearfix cart-total">
                                <div class="pull-right">
                                    <span class="text">Tổng cộng :</span><span class='price'><?php echo $_SESSION['tp'] = "$totalprice" . "$"; ?></span>
                                </div>
                                <div class="clearfix"></div>
                                <a href="my-cart.php" class="btn btn-upper btn-primary btn-block m-t-20">Giỏ Hàng Của Tôi</a>    
                            </div><!-- /.cart-total-->
                        </li>
                        </ul><!-- /.dropdown-menu-->
                    </div><!-- /.dropdown-cart -->
                <?php 
                } else { 
                ?>
                <div class="dropdown dropdown-cart">
                    <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                        <div class="items-cart-inner">
                            <div class="total-price-basket">
                                <span class="lbl">giỏ hàng -</span>
                                <span class="total-price">
                                    <span class="sign"></span>
                                    <span class="value">00.00$</span>
                                </span>
                            </div>
                            <div class="basket">
                                <i class="glyphicon glyphicon-shopping-cart"></i>
                            </div>
                            <div class="basket-item-count"><span class="count">0</span></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="cart-item product-summary">
                                <div class="row">
                                    <div class="col-xs-12">
                                        Giỏ hàng của bạn đang trống.
                                    </div>
                                </div>
                            </div><!-- /.cart-item -->
                            <hr>
                            <div class="clearfix cart-total">
                                <div class="clearfix"></div>
                                <a href="index.php" class="btn btn-upper btn-primary btn-block m-t-20">Tiếp Tục Mua Sắm</a>    
                            </div><!-- /.cart-total-->
                        </li>
                    </ul><!-- /.dropdown-menu-->
                </div>
                <?php } ?>
            </div><!-- /.top-cart-row -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div>
