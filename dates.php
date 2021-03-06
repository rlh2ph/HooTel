<!DOCTYPE HTML>
<html>
<?php
  session_start();

  $server = "mysql.cs.virginia.edu";
  $user = "am7eu";
  $password = "u9KzwMUi";
  $dbname = "am7eu_dbproject";
  $mysqli = new mysqli($server, $user, $password, $dbname);
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
$partysizeErr = $checkinErr = $checkoutErr = $roomnumErr = $nameErr = $cardnumErr = $expErr = $cvvErr = $priceErr = "";
$partysize = $checkin = $checkout = $roomnum = $name = $cardnum = $exp = $cvv = $price = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["partysize"])) {
    $partysizeErr = "Party size is required";
  } else {
    $partysize = test_input($_POST["partysize"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$partysize)) {
      $partysizeErr = "Party size must be a number";
    }
    else if($_POST["partysize"] > 8){
      $partysizeErr = "Party size cannot exceed 8 people";
    }
    else if($_POST["partysize"] == 0){
      $partysizeErr = "Party size cannot be 0";
    }
  }        
  if (empty($_POST["checkin"])) {
    $checkinErr = "Check in date is required";
  } else {
    $checkin = test_input($_POST["checkin"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^([0-9]{4})([-])([0-9]{2})([-])([0-9]{2})$/",$checkin)) {
      $checkinErr = "Check in date must be in the format of yyyy-mm-dd";
    }
  }
  if (empty($_POST["checkout"])) {
    $checkoutErr = "Check out date is required";
  } else {
    $checkout = test_input($_POST["checkout"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^([0-9]{4})([-])([0-9]{2})([-])([0-9]{2})$/",$checkout)) {
      $checkoutErr = "Check out date must be in the format of yyyy-mm-dd";
    }
  }
  if($_POST["checkout"] < $_POST["checkin"]){
    $checkoutErr = "Checkout cannot be before checkin";
  }
  if (empty($_POST["roomnum"])) {
    $roomnumErr = "Room number is required";
  } else {
    $roomnum = test_input($_POST["roomnum"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$roomnum)) {
      $roomnumErr = "Room number must be a number";
    }
  }
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

if($partysizeErr == "" && $checkinErr == "" && $checkoutErr == ""){
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
      // reservationInfo($mysqli,$_POST["checkin"],$_POST["checkout"],$_POST["roomnum"], $_POST["partysize"]);
      $_SESSION["checkin"] = $checkin;
      $_SESSION["checkout"] = $checkout;
      $_SESSION["partysize"] = $partysize;
      header("Location:reservation.php");
      die();

  }
}

// $state = 0;
// foreach($_POST as $key => $value) {
//   if(!empty($value)) {
//
//   }
//   else{
//     echo "Error, not all values given.";
//     $state += 1;
//     //echo $state;
//     die;
//   }
//
// }
// //echo $state;
// if ($state == 0){


?>

<?php
  include(dirname(__FILE__).'/components/nav.php');
?>
<div class="center-screen">
<h2 class="heading">Make a Reservation</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <h4 class="heading">Reservation Information</h4>
  <div class="heading">
  Check In: <input type="text" name="checkin" value="<?php echo $checkin;?>">
  <span class="error">* <?php echo $checkinErr;?></span>
  <br><br>
  Check Out: <input type="text" name="checkout" value="<?php echo $checkout;?>">
  <span class="error">* <?php echo $checkoutErr;?></span>
  <br><br>
  Party Size: <input type="text" name="partysize" value="<?php echo $partysize;?>">
  <span class="error">* <?php echo $partysizeErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Next">
</form>
</div>

<?php
// function reservationInfo($mysqli,$checkin,$checkout,$roomnum,$partysize){
//   $id = $_SESSION['guest_id'];
//   $reservation = "INSERT INTO reserve (check_in, check_out, room_num, guest_id, party_size) VALUES ('$checkin', '$checkout', '$roomnum', '$id', '$partysize')";
//   // update room table to make room not available
//   $update_room = "UPDATE room SET available = 0 WHERE room_num = '$roomnum'";
//   if(mysqli_query($mysqli, $reservation)){
//       echo "Reservation Records inserted successfully.";
//       if(mysqli_query($mysqli, $update_room)){
//         echo "Reservation Records inserted successfully.";
//         header("Location:index.php");
//         die();
//       }
//   } else{
//       echo "ERROR: Could not execute $reservation. " . mysqli_error($mysqli);
//   }
// }
 ?>




</body>
</html>
