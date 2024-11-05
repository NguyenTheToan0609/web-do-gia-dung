<?php
// Kết nối đến cơ sở dữ liệu
$con = new mysqli("localhost", "root", "", "shopping");

// Kiểm tra kết nối
if ($con->connect_error) {
    die("Kết nối thất bại: " . $con->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="path_to_your_css_file.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    margin-bottom: 30px;
}

.dashboard {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin: 0 auto;
    max-width: 1200px;
}

.dashboard-item {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin: 15px;
    padding: 20px;
    flex: 1;
    min-width: 250px;
    max-width: 350px;
    text-align: center;
}

.dashboard-item h2 {
    margin: 0 0 10px;
    font-size: 1.5em;
    color: #007BFF; /* Màu xanh */
}

.dashboard-item p {
    font-size: 1.2em;
    margin: 5px 0;
}

.dashboard-item p:last-child {
    font-weight: bold;
    color: #333;
}

@media (max-width: 768px) {
    .dashboard {
        flex-direction: column;
        align-items: center;
    }
}

.back-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007BFF; /* Màu xanh */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: #0056b3; /* Màu xanh đậm khi hover */
}

    </style>

</head>
<body>
    <h1>Tổng Quan</h1>
    <div class="dashboard">

        <div class="dashboard-item">
            <h2>Tổng số lượng đơn đặt hàng</h2>
            <?php
            $query_total_orders = "SELECT COUNT(*) as total_orders FROM orders";
            $result_total_orders = $con->query($query_total_orders);

            if ($result_total_orders) {
                $total_orders = $result_total_orders->fetch_assoc()['total_orders'];
                echo "<p>" . number_format($total_orders) . " đơn hàng</p>";
            } else {
                echo "<p>Có lỗi xảy ra: " . $con->error . "</p>";
            }
            ?>
        </div>

        <div class="dashboard-item">
            <h2>Tổng tiền</h2>
            <?php
            $query_total_money = "
                SELECT SUM(p.productPrice * o.quantity) as total_money
                FROM orders o
                JOIN products p ON o.productId = p.id
                WHERE o.paymentMethod IN ('COD', 'Internet Banking', 'Debit/Credit card')
            ";
            $result_total_money = $con->query($query_total_money);

            if ($result_total_money) {
                $total_money = $result_total_money->fetch_assoc()['total_money'];
                echo "Tổng tiền: $" . number_format($total_money, 2) ;
            } else {
                echo "Có lỗi xảy ra: " . $con->error;
            }
            ?>
        </div>

        <div class="dashboard-item">
            <h2>Tổng số người đã đăng ký</h2>
            <?php
            $query_total_users = "SELECT COUNT(*) as total_users FROM users";
            $result_total_users = $con->query($query_total_users);

            if ($result_total_users) {
                $total_users = $result_total_users->fetch_assoc()['total_users'];
                echo "<p>" . number_format($total_users) . " người dùng</p>";
            } else {
                echo "<p>Có lỗi xảy ra: " . $con->error . "</p>";
            }
            ?>
         </div>

         <div class="dashboard-item">
            <h2>Tổng số sản phẩm có trong kho</h2>
            <?php
            $query_total_products = "SELECT COUNT(*) as total_products FROM products";
            $result_total_products = $con->query($query_total_products);

            if ($result_total_products) {
                $total_products = $result_total_products->fetch_assoc()['total_products'];
                echo "<p>" . number_format($total_products) . " sản phẩm</p>";
            } else {
                echo "<p>Có lỗi xảy ra: " . $con->error . "</p>";
            }
            ?>
         </div>
         
    </div>
        <div style="text-align: center; margin-top: 20px;">
        <a href="todays-orders.php" class="back-button">Quay lại</a>
    </div>
</body>
</html>

<?php
// Đóng kết nối sau khi hoàn thành các truy vấn
$con->close();
?>
