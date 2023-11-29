function total() {
    var Latte;
    var Cappuccino;
    var Espresso;
    var sum;
    Latte = parseInt(document.getElementById("qty1").value);
    Cappuccino = parseInt(document.getElementById("qty2").value);
    Espresso = parseInt(document.getElementById("qty3").value);
    sum = (Latte * 2) + (Cappuccino * 5) + (Espresso * 3);
    document.getElementById("total_cost").innerHTML = "USD "+sum+".00";

  }
  function submit() {
    alert("Your Order has been Submitted, Successfully!");
  }