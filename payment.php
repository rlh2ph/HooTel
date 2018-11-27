<!DOCTYPE HTML>
<html>
<?php
  session_start();
  $mysqli = new mysqli("mysql.cs.virginia.edu", "am7eu", "u9KzwMUi", "am7eu_dbproject");
?>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>The HooTel</title>

<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>

  <!-- Bootstrap core CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

  <!-- Plugin CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/creative.min.css" rel="stylesheet">

<!--Our own css -->
<link href="reservation.css" rel="stylesheet">

</head>
  <body>




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
    $expErr = "Expiration Date is required";
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

<?php
//$payment = "INSERT INTO payment (price, card_num, exp, cvv, cardholder_name) VALUES ('$price', '$cardnum', '$exp', '$cvv', '$name')";
//if(mysqli_query($mysqli, $payment)){
//    echo "Records inserted successfully.";
//} else{
//    echo "ERROR: Could not able to execute $payment. " . mysqli_error($mysqli);
//}
?>

<?php
  include(dirname(__FILE__).'/components/nav.php');
?>

<div class="center-screen">
<h2 class="heading">Payment</h2>
<h4 class="heading">Card Information</h4>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="heading">
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
  <br>
  <hr style="width: 100px;">
  Price: $<input type="text" name="price" value="<?php echo $_SESSION['resAmt'];?>">
  <span class="error">* <?php echo $priceErr;?></span>
  <br><br>
</div>
  <input type="submit" name="submit" value="Submit">
</form>
</div>

<?php
$state = 0;
foreach($_POST as $key => $value) {
  if(!empty($value)) {

  }
  else{
    header("Refresh: 0; url=payment.php");
    alert("Error, not all values given.");
    $state += 1;

    //echo $state;
    die;
  }

}

function alert($msg) {
  echo "<script type='text/javascript'>alert('$msg');</script>";
}

$payment = "INSERT INTO payment (price, card_num, exp, cvv, cardholder_name) VALUES ('$price', '$cardnum', '$exp', '$cvv', '$name')";
if(mysqli_query($mysqli, $payment)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not execute $payment. " . mysqli_error($mysqli);
}
?>

</body>
</html>
