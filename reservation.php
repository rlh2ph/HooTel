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

<h2>Make a Reservation</h2>
<h4>Guest Information</h4>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  First name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
  <span class="error">* <?php echo $firstnameErr;?></span>
  <br><br>
  Last name: <input type="text" name="lastname" value="<?php echo $lastname;?>">
  <span class="error">* <?php echo $lastnameErr;?></span>
  <br><br>
  DOB: <input type="text" name="dob" value="<?php echo $dob;?>">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>
  Party Size: <input type="text" name="partysize" value="<?php echo $partysize;?>">
  <span class="error">* <?php echo $partysizeErr;?></span>
  <br><br>
  <h4>Reservation Information</h4>
  Check In: <input type="text" name="checkin" value="<?php echo $checkin;?>">
  <span class="error">* <?php echo $checkinErr;?></span>
  <br><br>
  Check Out: <input type="text" name="checkout" value="<?php echo $checkout;?>">
  <span class="error">* <?php echo $checkoutErr;?></span>
  <br><br>
  Room Num: <input type="text" name="roomnum" value="<?php echo $roomnum;?>">
  <span class="error">* <?php echo $roomnumErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

<?php
$state = 0;
foreach($_POST as $key => $value) {
  if(empty($value)) {
    echo "Error, not all values given.";
    $state += 1;
    //echo $state;
    die;
  }
  else{

  }

}
//echo $state;
if ($state == 0){
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
      guestInfo($firstname,$lastname,$dob,$partysize,$mysqli);
      reservationInfo($mysqli,$firstname,$lastname,$dob,$checkin,$checkout,$roomnum);
  }
}
function guestInfo($firstname,$lastname,$dob,$partysize,$mysqli){
  $guest = "INSERT INTO guest (first_name, last_name, DOB, party_size) VALUES ('$firstname', '$lastname', '$dob', '$partysize')";
  // $reservation = "INSERT INTO reserve (first_name, last_name, email) VALUES ('Peter', 'Parker', 'peterparker@mail.com')";
  if(mysqli_query($mysqli, $guest)){
      echo "Guest Records inserted successfully.";
  } else{
      echo "ERROR: Could not able to execute $guest. " . mysqli_error($mysqli);
  }
}
function reservationInfo($mysqli,$firstname,$lastname,$dob,$checkin,$checkout,$roomnum){
  $guest_id = mysqli_fetch_assoc($mysqli->query("SELECT guest_id FROM guest WHERE first_name = '$firstname' and last_name = '$lastname' and DOB = '$dob'"));
  $id = $guest_id['guest_id'];
  $reservation = "INSERT INTO reserve (check_in, check_out, room_num, guest_id) VALUES ('$checkin', '$checkout', '$roomnum', '$id')";

  if(mysqli_query($mysqli, $reservation)){
      echo "Reservation Records inserted successfully.";
  } else{
      echo "ERROR: Could not able to execute $reservation. " . mysqli_error($mysqli);
  }
}



// $result = $mysqli->query("SELECT * FROM guest WHERE first_name = 'Mark'");
//
// while ($row = mysqli_fetch_assoc($result)) {
//   echo "Guest ID: ";
//   echo $row['guest_id'];
//   echo "<br>";
//   echo "Last Name: ";
//   echo $row['last_name'];
//   echo "<br>";
//   echo "First Name: ";
//   echo $row['first_name'];
//   echo "<br>";
//   echo "DOB: ";
//   echo $row['DOB'];
//   echo "<br>";
// }
?>

</body>
</html>
