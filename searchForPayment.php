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
?>
<?php
$fname = $dob = $lname = $checkin = $checkout = "";
$fnameErr = $dobErr = $lnameErr = $checkinErr = $checkoutErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["fname"])) {
    $fnameErr = "First Name is Required!";
  } else {
    $fname = test_input($_POST["fname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $fnameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["lname"])) {
    $lnameErr = "Last Name is Required!";
  } else {
    $lname = test_input($_POST["lname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $lnameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["dob"])) {
    $dobErr = "Date of birth is required!";
  } else {
    $dob = test_input($_POST["dob"]);
    if (!preg_match("/^([0-9]{4})([-])([0-9]{2})([-])([0-9]{2})$/",$dob)) {
      $dobErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["checkin"])) {
    $checkinErr = "Date of birth is required!";
  } else {
    $checkin = test_input($_POST["checkin"]);
    if (!preg_match("/^([0-9]{4})([-])([0-9]{2})([-])([0-9]{2})$/",$checkin)) {
      $checkinErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["checkout"])) {
    $checkoutErr = "Date of birth is required!";
  } else {
    $checkout = test_input($_POST["checkout"]);
    if (!preg_match("/^([0-9]{4})([-])([0-9]{2})([-])([0-9]{2})$/",$checkout)) {
      $checkoutErr = "Only letters and white space allowed";
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

<h2>Search For Guest Payment<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  First Name: <input type="text" name="fname" value="<?php echo $fname;?>">
  <span class="error">* <?php echo $fnameErr;?></span>
  <br><br>
  Last Name: <input type="text" name="lname" value="<?php echo $lname;?>">
  <span class="error">* <?php echo $lnameErr;?></span>
  <br><br>
  Date of Birth: <input type="text" name="dob" value="<?php echo $dob;?>">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>
  Check In: <input type="text" name="checkin" value="<?php echo $checkin;?>">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>
  Check Out: <input type="text" name="checkout" value="<?php echo $checkout;?>">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    session_start();
    $paymentAmount = submit($fname,$lname,$dob,$mysqli,$checkin,$checkout);
    $_SESSION['resAmt'] = $paymentAmount;
    header("Location:payment.php");

}
function submit($fname,$lname,$dob,$mysqli,$checkin,$checkout){
  echo $fname;
  echo "<br>";
  echo $lname;
  echo "<br>";
  echo $dob;
  echo "<br>";
  echo $checkin;
  echo "<br>";
  echo $checkout;
  echo "<br>";
  $result = $mysqli->query("SELECT `guest_id` FROM `guest` WHERE `last_name` = '$lname' AND `first_name` = '$fname' AND `DOB` = '$dob'");
  $row = mysqli_fetch_assoc($result);
  echo $row['guest_id'];
  echo "<br>";
  $gID = $row['guest_id'];
  $result2 = $mysqli->query("SELECT * FROM `reserve` WHERE`check_in` = '$checkin' AND `check_out` = '$checkout' AND  `guest_id` = '$gID'");
  $row2 = mysqli_fetch_assoc($result2);
  echo "res id: " . $row2['res_id'];
  echo "<br>";
  $rID = $row2['res_id'];
  $result3 = $mysqli->query("SELECT * FROM `payment` WHERE `reservation_id` = '$rID'");
  $row3 = mysqli_fetch_assoc($result3);
  $amount  = $row3['price'];
  echo "Price: " . $amount;
  return $amount;
}


?>

</body>
</html>
