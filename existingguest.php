<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php
  session_start();

  $server = "mysql.cs.virginia.edu";
  $user = "am7eu";
  $password = "u9KzwMUi";
  $dbname = "am7eu_dbproject";
  $mysqli = new mysqli($server, $user, $password, $dbname);
?>

<?php
// define variables and set to empty values
$firstnameErr = $lastnameErr = $dobErr = $partysizeErr = $checkinErr = $checkoutErr = $roomnumErr = "";
$firstname = $lastname = $dob = $partysize = $checkin = $checkout = $roomnum = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstname"])) {
    $firstnameErr = "First name is required";
  } else {
    $firstname = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
      $firstnameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["lastname"])) {
    $lastnameErr = "Last name is required";
  } else {
    $lastname = test_input($_POST["lastname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $lastnameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["dob"])) {
    $dobErr = "Date of Birth is required";
  } else {
    $dob = test_input($_POST["dob"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^([0-9]{4})([-])([0-9]{2})([-])([0-9]{2})$/",$dob)) {
      $dobErr = "DOB must be in the format of yyyy-mm-dd";
    }
  }
  if (empty($_POST["partysize"])) {
    $partysizeErr = "Party size is required";
  } else {
    $partysize = test_input($_POST["partysize"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$partysize)) {
      $partysizeErr = "Party size must be a number";
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
  if (empty($_POST["roomnum"])) {
    $roomnumErr = "Room number is required";
  } else {
    $roomnum = test_input($_POST["roomnum"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$roomnum)) {
      $roomnumErr = "Room number must be a number";
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

<h2>Existing Guests</h2>
<form action='reservation.php' method="post">
  <?php
  $sql=mysqli_query($mysqli, "SELECT * FROM guest");
  if(mysqli_num_rows($sql)){
  $select= '<select name="guest">';
  while($rs=mysqli_fetch_array($sql)){
        $select.='<option value="'.$rs['guest_id'].'">'.$rs['first_name'].' '.$rs['last_name'].' -- '.$rs['DOB'].'</option>';
    }
  }
  $select.='</select>';
  echo $select;
  ?>
  <br>
  <input type="submit" name="submit" value="Submit">
</form>

<?php
if (isset($_POST['submit'])) {
     $_SESSION['guest_id'] = $_POST['guest'];
}
?>


</body>
</html>
