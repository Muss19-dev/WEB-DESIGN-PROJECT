let totalItems = 0;
let totalCost = 0;

function addToCart(price, qty)
{
  let AmountNeeded = parseInt(document.getElementById(qty).value);

  totalItems += AmountNeeded;

  totalCost += AmountNeeded * price;

  document.getElementById("items").innerHTML = totalItems;

  document.getElementById("cost").innerHTML = totalCost;
}
