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
$roomnumErr = $nameErr = $cardnumErr = $expErr = $cvvErr = $priceErr = "";
$roomnum = $name = $cardnum = $exp = $cvv = $price = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $cardnumErr = "Card number is required";
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
   if (!preg_match("/^([0-9]{2})\/([0-9]{2})$/",$exp)) {
     $expErr = "Expiration date must be in the format of yy/mm";
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
if($roomnumErr == "" && $nameErr == "" && $cardnumErr == "" && $expErr == "" && $cvvErr == "" && $priceErr == ""){
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
      $res_id = reservationInfo($mysqli,$_SESSION["checkin"],$_SESSION["checkout"],$_POST["roomnum"], $_SESSION["partysize"]);
      $pay_id = paymentInfo($mysqli, $_POST["name"], $_POST["cardnum"], $_POST["exp"], $_POST["cvv"], $_POST["price"], $res_id);
      header("Location:index.php");
      die();
  }
}


?>

<?php
  include(dirname(__FILE__).'/components/nav.php');

?>
<div class="center-screen">
<h2 class="heading">Make a Reservation</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="heading">
  <?php
  $in = $_SESSION["checkin"];
  $out = $_SESSION["checkout"];
  $party = $_SESSION["partysize"];
  if($party < 8 and $party!=2 and $party!=4){
    $sql=mysqli_query($mysqli, "SELECT distinct room_num from (SELECT room_num FROM room WHERE room_num NOT IN (
      SELECT room_num FROM reserve WHERE
      ('$in' <= reserve.check_in && '$in' <= reserve.check_out && reserve.check_in <= '$out' && '$out' <=reserve.check_out) ||
      (reserve.check_in <= '$in' && '$in' <= reserve.check_out && reserve.check_in <= '$out' && '$out' <= reserve.check_out) ||
      (reserve.check_in <= '$in' && reserve.check_in <= '$out' && '$in' <= reserve.check_out && reserve.check_out <= '$out') ||
      ('$in' <= reserve.check_in && '$in' <= reserve.check_out && reserve.check_in <= '$out' && reserve.check_out <= '$out')
    )) AS foo WHERE room_num IN ( SELECT room_num FROM room WHERE type_id NOT IN ( SELECT type_id FROM room_type WHERE room_type.capacity <=$party)
  )");
  }
  else{
    $sql=mysqli_query($mysqli, "SELECT distinct room_num from (SELECT room_num FROM room WHERE room_num NOT IN (
    SELECT room_num FROM reserve WHERE
    ('$in' <= reserve.check_in && '$in' <= reserve.check_out && reserve.check_in <= '$out' && '$out' <=reserve.check_out) ||
    (reserve.check_in <= '$in' && '$in' <= reserve.check_out && reserve.check_in <= '$out' && '$out' <= reserve.check_out) ||
    (reserve.check_in <= '$in' && reserve.check_in <= '$out' && '$in' <= reserve.check_out && reserve.check_out <= '$out') ||
    ('$in' <= reserve.check_in && '$in' <= reserve.check_out && reserve.check_in <= '$out' && reserve.check_out <= '$out')
    )) AS foo WHERE room_num IN
    ( SELECT room_num FROM room WHERE type_id IN ( SELECT type_id FROM room_type WHERE room_type.capacity =$party)
  )");
  }


  if(mysqli_num_rows($sql)){
  $select= 'Room #: <select name="roomnum">';
  while($rs=mysqli_fetch_array($sql)){
        $select.='<option value="'.$rs['room_num'].'">'.$rs['room_num'].'</option>';
    }
  }
  $select.='</select>';
  echo $select;
  ?>
</br><br>
</div>
<hr>
<h4 class="heading">Credit Card Information</h4>
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
  <br><br>
  Price: $<input type="text" name="price" value="<?php echo $price;?>">
  <span class="error">* <?php echo $priceErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>
</div>

<?php
function reservationInfo($mysqli,$checkin,$checkout,$roomnum,$partysize){
  $id = $_SESSION['guest_id'];
  $reservation = "INSERT INTO reserve (check_in, check_out, room_num, guest_id, party_size) VALUES ('$checkin', '$checkout', '$roomnum', '$id', '$partysize')";
  // update room table to make room not available
  $update_room = "UPDATE room SET available = 0 WHERE room_num = '$roomnum'";
  $ret;
  if(mysqli_query($mysqli, $reservation)){
      echo "Reservation Records inserted successfully.";
      $ret = $mysqli->insert_id;
      if(mysqli_query($mysqli, $update_room)){
        echo "Reservation Records inserted successfully.";
      }
  } else{
      echo "ERROR: Could not execute $reservation. " . mysqli_error($mysqli);
  }
  return $ret;
}

function paymentInfo($mysqli, $name, $cardnum, $exp, $cvv, $price, $res_id){
  $payment = "INSERT INTO payment (price, card_num, exp, cvv, cardholder_name, reservation_id) VALUES ('$price', '$cardnum', '$exp', '$cvv', '$name', '$res_id')";
  if(mysqli_query($mysqli, $payment)){
    echo "Payment records inserted successfully.";
  }
  else{
    echo "ERROR: Could not execute $payment. " . mysqli_error($mysqli);
  }
}
?>




</body>
</html>
