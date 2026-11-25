<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$con=mysqli_connect("localhost","root","","auca_canteen");
if(mysqli_connect_errno()){
    echo "Failed to connect to the server" .mysqli_connect_error();
}
if(isset($_POST['newItem'])){
    $prodName=mysqli_real_escape_string($con,$_POST['prodName']);
    $image=mysqli_real_escape_string($con,$_POST['image']);
    $category=mysqli_real_escape_string($con,$_POST['category']);
    $price=mysqli_real_escape_string($con,$_POST['price']);
    $quantity=mysqli_real_escape_string($con,$_POST['quantity']);
    $status=mysqli_real_escape_string($con,$_POST['status']);
    $sql1="INSERT INTO product(ProductName,Image,Category,Price, Quantity, Status) VALUES ('$prodName','$image','$category','$price','$quantity','$status')";
    if(!mysqli_query($con,$sql1)){
        echo "Error! ". mysqli_error($con);
    } else{
        echo "Item added succcessfully.";
    }
} 
if(isset($_POST['changePrice'])){
    $itemName=mysqli_real_escape_string($con,$_POST['itemName']);
    $newPrice=mysqli_real_escape_string($con,$_POST['newPrice']);
    $sql2="UPDATE product SET price='$newPrice' WHERE ProductName='$itemName'";
    if(!mysqli_query($con,$sql2)){
        echo "Error! ". mysqli_error($con);
    } else {
        echo "Item's Price updated successfully!";
    }
}
if(isset($_POST['addQuantity'])){
    $prodName2=mysqli_real_escape_string($con,$_POST['productName']);
    $addedQuantity=mysqli_real_escape_string($con,$_POST['addedQuantity']);
    $sql3="UPDATE product SET Quantity= Quantity + '$addedQuantity' WHERE ProductName='$prodName2'";
    if(!mysqli_query($con,$sql3)){
        echo "Error! " . mysqli_error($con);
    } else{
        echo "Item's Quantity updated successfully!";
    }
}
?>