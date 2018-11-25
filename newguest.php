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
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>New Guest</h2>
<h4>Guest Information</h4>
<p><span class="error">* required field</span></p>
<form method="post" action="reservation.php">
  First Name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
  <span class="error">* <?php echo $firstnameErr;?></span>
  <br><br>
  Last Name: <input type="text" name="lastname" value="<?php echo $lastname;?>">
  <span class="error">* <?php echo $lastnameErr;?></span>
  <br><br>
  DOB: <input type="text" name="dob" value="<?php echo $dob;?>">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    submit($firstname, $lastname, $dob, $mysqli);
}
function submit($firstname, $lastname, $dob, $mysqli){
  $guest = "INSERT INTO guest (first_name, last_name, DOB) VALUES ('$firstname', '$lastname', '$dob')";
  if(mysqli_query($mysqli, $guest)){
      echo "Records inserted successfully.";
      $_SESSION['guest_id'] = $mysqli->insert_id;
  } else{
      echo "ERROR: Could not able to execute $guest. " . mysqli_error($mysqli);
  }
}
?>

</body>
</html>
