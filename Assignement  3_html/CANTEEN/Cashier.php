<?php

session_start();

if(!isset($_SESSION['UserId']))
{
    header("Location: ../LOGIN/Login.html");
    exit();
}
$con = mysqli_connect("localhost","root","","auca_canteen");
if(!$con)
{
    die("Connection Failed: " . mysqli_connect_error());
}
$orderCountQuery ="SELECT COUNT(*) AS TotalOrders FROM orders";
$orderCountResult =mysqli_query($con,$orderCountQuery);
$orderCount =mysqli_fetch_assoc($orderCountResult);
$pendingQuery ="SELECT COUNT(*) AS PendingOrders FROM orders WHERE Status='Pending'";
$pendingResult =mysqli_query($con,$pendingQuery);
$pendingOrders =mysqli_fetch_assoc($pendingResult);
$completedQuery ="SELECT COUNT(*) AS CompletedOrders FROM orders WHERE Status='Paid'";
$completedResult =mysqli_query($con,$completedQuery);
$completedOrders =mysqli_fetch_assoc($completedResult);
$revenueQuery ="SELECT SUM(TotalAmount) AS Revenue FROM orders WHERE Status='Paid'";
$revenueResult =mysqli_query($con,$revenueQuery);
$revenue =mysqli_fetch_assoc($revenueResult);
$ordersQuery ="SELECT orders.OrderId,users.UserName,orders.TotalAmount,orders.Status
FROM orders INNER JOIN users ON orders.UserId = users.UserId";
$ordersResult =mysqli_query($con,$ordersQuery);
$productQuery ="SELECT * FROM product";
$productResult =mysqli_query($con,$productQuery);
?>
<html>
<head>
    <title>AUCA Canteen - Cashier Dashboard</title>
    <link rel="stylesheet" type="text/css" href="Cashier.css">
</head>

<body>

<div class="menu">
    <div>Dashboard</div>
    <div>Customer Orders</div>
    <div>Payments</div>
    <div>Receipts</div>
    <div>Products</div>
    <div>Logout</div>
</div>

<h1>AUCA Canteen Cashier Dashboard</h1>

<div class="summary">

    <div class="card">
        <h3>Today's Orders</h3>
        <p>
            <?php echo $orderCount['TotalOrders']; ?>
        </p>
    </div>

    <div class="card">
        <h3>Pending Orders</h3>
        <p>
            <?php echo $pendingOrders['PendingOrders']; ?>
        </p>
    </div>

    <div class="card">
        <h3>Completed Orders</h3>
        <p>
            <?php echo $completedOrders['CompletedOrders']; ?>
        </p>
    </div>

    <div class="card">
        <h3>Revenue Today</h3>
        <p>
            <?php echo $revenue['Revenue']; ?> RWF
        </p>
    </div>

</div>

<h2>Pending Customer Orders</h2>

<table border="1">

<tr>
    <th>Order ID</th>
    <th>Customer Name</th>
    <th>Total Amount</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php

while($order = mysqli_fetch_assoc($ordersResult))
{
?>

<tr>

    <td>
        <?php echo $order['OrderId']; ?>
    </td>

    <td>
        <?php echo $order['UserName']; ?>
    </td>

    <td>
        <?php echo $order['TotalAmount']; ?> RWF
    </td>

    <td>
        <?php echo $order['Status']; ?>
    </td>

    <td>

        <form action="ProcessPayment.php" method="post">

            <input type="hidden" name="OrderId" value="<?php echo $order['OrderId']; ?>">

            <input type="submit" value="Process Payment">

        </form>

        <form action="OrderDetails.php" method="post">

          <input type="hidden" name="OrderId" value="<?php echo $order['OrderId']; ?>">

          <input type="submit" value="View Details">

        </form>

    </td>

</tr>

<?php
}
?>

</table>

<h2>Product Availability</h2>

<table border="1">

<tr>
    <th>PRODUCT</th>
    <th>CATEGORY</th>
    <th>PRICE (RWF)</th>
    <th>QUANTITY</th>
    <th>STATUS</th>
</tr>

<?php

while($product = mysqli_fetch_assoc($productResult))
{
?>

<tr>

<td>

    <img src="../PICTURES/<?php echo $product['Image']; ?>"
         width="50"
         height="50">

    <br>

    <?php echo $product['ProductName']; ?>

</td>

<td>
    <?php echo $product['Category']; ?>
</td>

<td>
    <?php echo $product['Price']; ?>
</td>

<td>
    <?php echo $product['Quantity']; ?>
</td>

<td>
    <?php echo $product['Status']; ?>
</td>

</tr>

<?php
}
?>

</table>
<br>
<footer>
    AUCA Canteen Management System © 2026
</footer>

</body>

</html>
