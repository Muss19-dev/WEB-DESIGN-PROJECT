let totalItems = 0;
let totalCost = 0;

function addToCart(price, qty)
{
  let amountNeeded = parseInt(document.getElementById(qty).value);

  totalItems += amountNeeded;

  totalCost += amountNeeded * price;

  totalItems=document.getElementById("items").innerHTML

  totalCost=document.getElementById("cost").innerHTML
}
