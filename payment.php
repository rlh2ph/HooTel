<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>


<?php
  $mysqli = new mysqli("mysql.cs.virginia.edu", "am7eu", "u9KzwMUi", "am7eu_dbproject");
  session_start();
?>

<?php
// define variables and set to empty values
$nameErr = $cardnumErr = $expErr = $cvvErr = $priceErr = "";
$name = $cardnum = $exp = $cvv = $price = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Cardholder name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["cardnum"])) {
    $cardnumErr = "Last name is required";
  } else {
    $cardnum = test_input($_POST["cardnum"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/",$cardnum)) {
      $cardnumErr = "Enter card format in the form xxxx xxxx xxxx xxxx";
    }
  }
  if (empty($_POST["exp"])) {
    $expErr = "Date of Birth is required";
  } else {
    $exp = test_input($_POST["exp"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]{2}\/[0-9]{2}$/",$exp)) {
      $expErr = "Expiration date must be in the format of mm/yy";
    }
  }
  if (empty($_POST["cvv"])) {
    $cvvErr = "Party size is required";
  } else {
    $cvv = test_input($_POST["cvv"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]{3}$/",$cvv)) {
      $cvvErr = "CVV must be in the format of XXX";
    }
  }
  if (empty($_POST["price"])) {
    $priceErr = "Check in date is required";
  } else {
    $price = test_input($_POST["price"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$price)) {
      $priceErr = "Price must only contain numbers";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Payment</h2>
<h4>Card Information</h4>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Cardholder Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Credit Card Number: <input type="text" name="cardnum" value="<?php echo $cardnum;?>">
  <span class="error">* <?php echo $cardnumErr;?></span>
  <br><br>
  Expiration Date: <input type="text" name="exp" value="<?php echo $exp;?>">
  <span class="error">* <?php echo $expErr;?></span>
  <br><br>
  CVV: <input type="text" name="cvv" value="<?php echo $cvv;?>">
  <span class="error">* <?php echo $cvvErr;?></span>
  <br><br><br><br>
  Price: $<input type="text" name="price" value="<?php echo $_SESSION['resAmt'];?>">
  <span class="error">* <?php echo $priceErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

<?php

$payment = "INSERT INTO payment (price, card_num, exp, cvv, cardholder_name) VALUES ('$price', '$cardnum', '$exp', '$cvv', '$name')";
if(mysqli_query($mysqli, $payment)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $payment. " . mysqli_error($mysqli);
}
?>

</body>
</html>
