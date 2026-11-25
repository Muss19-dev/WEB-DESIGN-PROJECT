<?php

$con = mysqli_connect("localhost","root","","auca_canteen");

if(!$con)
{
    die("Connection Failed: " . mysqli_connect_error());
}

session_start();

if(!isset($_SESSION['UserId']))
{
    header("Location: Login.html");
    exit();
}

$sql = "SELECT * FROM product";

$result = mysqli_query($con,$sql);

?>
<html>
<head>

    <title>AUCA CANTEEN MANAGEMENT SYSTEM</title>

    <link rel="stylesheet" type="text/css" href="Customer.css">

    <script type="text/javascript" src="Customer.js"></script>

</head>
<body>
<div class="Menu">

    <div>HOME</div>
    <div>MENU</div>
    <div>MY ORDERS</div>
    <div>BILLING</div>
    <div>LOG OUT</div>

</div>
<h2>WELCOME TO AUCA CANTEEN</h2>
<div class="Container">

    <h4>AVAILABLE PRODUCTS</h4>

    <table border="1">

        <tr>
            <th>PRODUCT</th>
            <th>CATEGORY</th>
            <th>PRICE (RWF)</th>
            <th>QUANTITY</th>
            <th>STATUS</th>
            <th>AMOUNT NEEDED</th>
            <th>ACTION</th>
        </tr>

        <?php

        $counter = 1;

        while($row = mysqli_fetch_assoc($result))
        {
        ?>

        <tr>

            <td>

                <img
                        src="PICTURES/<?php echo $row['Image']; ?>"
                        width="60"
                        height="60"
                        alt="Product Image">

                <br>

                <?php echo $row['ProductName']; ?>

            </td>

            <td><?php echo $row['Category']; ?></td>

            <td><?php echo $row['Price']; ?></td>

            <td><?php echo $row['Quantity']; ?></td>

            <td><?php echo $row['Status']; ?></td>

            <td>

                <input
                        type="number"
                        id="qty<?php echo $counter; ?>"
                        min="1"
                        max="<?php echo $row['Quantity']; ?>"
                        value="1">

            </td>

            <td>

                <input
                        type="button"
                        value="Add To Cart"
                        onclick="addToCart(
                            <?php echo $row['Price']; ?>,
                            'qty<?php echo $counter; ?>'
                         )">

            </td>

        </tr>

        <?php

            $counter++;

        }

        ?>

    </table>


    <div class="summary">

        <h3>Cart Summary</h3>

        <p>
            Total Items :
            <span id="items">0</span>
        </p>

        <p>
            Total Cost :
            <span id="cost">0 RWF</span>
        </p>

        <input type="button" value="Clear Cart"><br>

        <form action="Checkout.php" method="post">

             <input type="hidden" id="totalAmount" name="totalAmount">

              <input type="submit" value="Check Out">

        </form>

    </div>

</div>

<footer>

    AUCA Canteen Management System © 2026

</footer>

</body>
</html>
