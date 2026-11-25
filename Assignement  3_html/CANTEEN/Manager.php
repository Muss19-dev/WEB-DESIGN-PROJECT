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
    die("Connection Failed : " . mysqli_connect_error());
}
$salesQuery ="SELECT SUM(TotalAmount) AS TotalSales FROM orders WHERE Status='Paid'";
$salesResult =mysqli_query($con,$salesQuery);
$sales =mysqli_fetch_assoc($salesResult);
$orderQuery ="SELECT COUNT(*) AS TotalOrders FROM orders";
$orderResult =mysqli_query($con,$orderQuery);
$orders =mysqli_fetch_assoc($orderResult);
$customerQuery ="SELECT COUNT(*) AS TotalCustomers FROM users WHERE Role='customer'";
$customerResult =mysqli_query($con,$customerQuery);
$customers =mysqli_fetch_assoc($customerResult);$outQuery ="SELECT COUNT(*) AS OutOfStock FROM product WHERE Quantity = 0";
$outResult =mysqli_query($con,$outQuery);
$outStock =mysqli_fetch_assoc($outResult);
$reportQuery ="SELECT OrderDate,COUNT(OrderId) AS Orders,SUM(TotalAmount) AS Revenue
FROM orders
GROUP BY OrderDate
ORDER BY OrderDate DESC";
$reportResult =mysqli_query($con,$reportQuery);
$productQuery ="SELECT * FROM product";
$productResult =mysqli_query($con,$productQuery);
$totalProductsQuery ="SELECT COUNT(*) AS TotalProducts FROM product";
$totalProductsResult =mysqli_query($con,$totalProductsQuery);
$totalProducts =mysqli_fetch_assoc($totalProductsResult);
$totalUsersQuery ="SELECT COUNT(*) AS TotalUsers FROM users";
$totalUsersResult =mysqli_query($con,$totalUsersQuery);
$totalUsers =mysqli_fetch_assoc($totalUsersResult);
$totalRevenueQuery ="SELECT SUM(TotalAmount) AS TotalRevenue FROM orders WHERE Status='Paid'";
$totalRevenueResult =mysqli_query($con,$totalRevenueQuery);
$totalRevenue =mysqli_fetch_assoc($totalRevenueResult);

?>

<html>

<head>

    <link rel="stylesheet" type="text/css" href="Manager.css">

    <title>
        AUCA Canteen - Senior Manager Dashboard
    </title>

</head>

<body>

<div class="menu">

    <div>Dashboard</div>
    <div>Sales Reports</div>
    <div>Inventory Reports</div>
    <div>User Management</div>
    <div>System Reports</div>
    <div>Logout</div>

</div>

<h1>Senior Manager Dashboard</h1>

<div class="summary">

    <div class="card">
        <h3>Total Sales</h3>

         <p>
                    <?php echo $sales['TotalSales']; ?> RWF
         </p>
     </div>

     <div class="card">
        <h3>Total Orders</h3>

                <p>
                    <?php echo $orders['TotalOrders']; ?>
                </p>
            </div>

            <div class="card">
                <h3>Total Customers</h3>

                <p>
                    <?php echo $customers['TotalCustomers']; ?>
                </p>
            </div>

            <div class="card">
                <h3>Products Out of Stock</h3>

                <p>
                    <?php echo $outStock['OutOfStock']; ?>
                </p>
            </div>

        </div>

        <h2>Daily Sales Report</h2>

        <table border="1">

        <tr>
            <th>Date</th>
            <th>Orders</th>
            <th>Revenue</th>
        </tr>

        <?php

        while($report = mysqli_fetch_assoc($reportResult))
        {
        ?>

        <tr>

            <td>
                <?php echo $report['OrderDate']; ?>
            </td>

            <td>
                <?php echo $report['Orders']; ?>
            </td>

            <td>
                <?php echo $report['Revenue']; ?> RWF
            </td>

        </tr>

        <?php
        }
        ?>

        </table>

        <h2>Inventory Status</h2>

        <table border="1">

        <tr>
            <th>PRODUCT</th>
            <th>QUANTITY</th>
            <th>STATUS</th>
        </tr>

        <?php

        while($product =
              mysqli_fetch_assoc($productResult))
        {
        ?>

        <tr>

        <td>
            <?php echo $product['ProductName']; ?>
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

        <div class="System">

            <h2>System Performance</h2>

            <p>
                Total Products:
                <?php echo $totalProducts['TotalProducts']; ?>
            </p>

            <p>
                Total Registered Users:
                <?php echo $totalUsers['TotalUsers']; ?>
            </p>

            <p>
                Total Revenue:
                <?php echo $totalRevenue['TotalRevenue']; ?> RWF
            </p>

            <a href="MonthlyReport.php">
                <button>
                    Generate Monthly Report
                </button>
            </a>

            <a href="ExportReport.php">
                <button>
                    Export Report
                </button>
            </a>

        </div>
        <br>
        <footer>

            AUCA Canteen Management System © 2026

        </footer>

        </body>

        </html>