<?php

session_start();

if(!isset($_SESSION['UserId']))
{
    header("Location: ../LOGIN/Login.html");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost","root","","auca_canteen");

if(mysqli_connect_errno())
{
    echo "Failed to connect to the server "
         . mysqli_connect_error();
}
if(isset($_POST['newItem']))
{
    $prodName =mysqli_real_escape_string($con,$_POST['prodName']);
    $image =mysqli_real_escape_string($con,$_POST['image']);
    $category =mysqli_real_escape_string($con,$_POST['category']);
    $price =mysqli_real_escape_string($con,$_POST['price']);
    $quantity =mysqli_real_escape_string($con,$_POST['quantity']);
    $status =mysqli_real_escape_string($con,$_POST['status']);

    $sql1 =
    "INSERT INTO product(
        ProductName,
        Image,
        Category,
        Price,
        Quantity,
        Status
    )
    VALUES
    (
        '$prodName',
        '$image',
        '$category',
        '$price',
        '$quantity',
        '$status'
    )";

    if(!mysqli_query($con,$sql1))
    {
        echo "Error! "
             . mysqli_error($con);
    }
    else
    {
        echo "Item added successfully.";
    }
}
if(isset($_POST['changePrice']))
{
    $itemName =mysqli_real_escape_string($con,$_POST['itemName']);
    $newPrice =mysqli_real_escape_string($con,$_POST['newPrice']);

    $sql2 ="UPDATE product SET Price='$newPrice' WHERE ProductName='$itemName'";

    if(!mysqli_query($con,$sql2))
    {
        echo "Error! "
             . mysqli_error($con);
    }
    else
    {
        echo "Item's Price updated successfully!";
    }
}
if(isset($_POST['addQuantity']))
{
    $prodName2 =mysqli_real_escape_string($con,$_POST['productName']);
    $addedQuantity =mysqli_real_escape_string($con,$_POST['addedQuantity']);

    $sql3 ="UPDATE product SET Quantity =Quantity + '$addedQuantity'
     WHERE ProductName='$prodName2'";

    if(!mysqli_query($con,$sql3))
    {
        echo "Error! "
             . mysqli_error($con);
    }
    else
    {
        echo "Item's Quantity updated successfully!";
    }
}
if(isset($_POST['deleteProduct']))
{
    $deleteItem =mysqli_real_escape_string($con,$_POST['deleteItem']);
    $deleteQuery ="DELETE FROM product WHERE ProductName='$deleteItem'";

    if(!mysqli_query($con,$deleteQuery))
    {
        echo "Error! "
             . mysqli_error($con);
    }
    else
    {
        echo "Item deleted successfully!";
    }
}
$productQuery ="SELECT * FROM product";
$productResult =mysqli_query($con,$productQuery);

?>

<html>
<head>
<title>
AUCA Canteen - Supervisor Dashboard
</title>
<link rel="stylesheet" type="text/css" href="Supervisor.css">
</head>
<body>
<h3>WELCOME BACK!</h3>

<div class="navbar">

    <div>
        <img
        src="../PICTURES/auca2.jpg"
        alt=""
        id="img">
    </div>

    <div>
        STOCK MANAGEMENT
    </div>

    <div>
        <img
        src="../PICTURES/auca2.jpg"
        alt=""
        id="img">
    </div>

</div>

<div class="div1">

<br>

<div class="div2">

<div>

<h4>
Add New Item
</h4>

<pre>
     <form action="Supervisor.php" method="post">

         PRODUCT NAME:<input type="text" name="prodName" required>

           IMAGE NAME:<input type="text" name="image"required>

             CATEGORY:<input type="text" name="category" required>

                PRICE:<input type="number" name="price" required>

             QUANTITY:<input type="number" name="quantity" required>

               STATUS:<input type="text" name="status" required>

               <input type="submit" name="newItem" value="ADD ITEM">

               <input type="reset" value="CANCEL">
     </form>
</pre>

</div>

<div class="div3">

<div>

<h4>Update Item Price</h4>

<pre>
     <form action="Supervisor.php"method="post">

           ITEM NAME:<input type="text" name="itemName"required>

           NEW PRICE:<input type="number" name="newPrice" required>

         <input type="submit" name="changePrice" value="UPDATE">

         <input type="reset" value="CANCEL">
     </form>
</pre>

</div>

<div>

<h4>Adjust Stock Quantity</h4>

<pre>
     <form action="Supervisor.php" method="post">

           PRODUCT NAME:<input type="text" name="productName" required>

         ADDED QUANTITY:<input type="number" name="addedQuantity" required>

          <input type="submit" name="addQuantity" value="ADJUST">

          <input type="reset" value="CANCEL">
     </form>
</pre>

</div>

<div>

<h4>Delete Product</h4>

<pre>
     <form action="Supervisor.php" method="post">

          PRODUCT NAME:<input type="text" name="deleteItem" required>

         <input type="submit" name="deleteProduct" value="DELETE">
     </form>
</pre>

</div>

</div>

</div>

</div>

<div>
<h2>Current Inventory</h2>

<table border="1">

<tr>

<th>Product</th>
<th>Image</th>
<th>Category</th>
<th>Price</th>
<th>Quantity</th>
<th>Status</th>

</tr>

</div>

<?php

while($row =
      mysqli_fetch_assoc($productResult))
{
?>

<tr>
<td><?php echo $row['ProductName']; ?></td>
<td><?php echo $row['Image']; ?></td>
<td><?php echo $row['Category']; ?></td>
<td><?php echo $row['Price']; ?></td>
<td><?php echo $row['Quantity']; ?></td>
<td><?php echo $row['Status']; ?></td>
</tr>

<?php
}
?>

</table>

</body>

</html>