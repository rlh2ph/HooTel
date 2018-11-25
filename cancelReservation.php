<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php
$conn = new mysqli("mysql.cs.virginia.edu", "am7eu", "u9KzwMUi", "am7eu_dbproject");
?>
<?php
$Err = "";
$reservationNumber = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (empty($_POST["res_id"])) {
    $Err = "Reservation ID is required";
  } else {
    $reservationNumber = test_input($_POST["res_id"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$reservationNumber)) {
      $Err = "Only letters and white space allowed";
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

<h2>Cancel Reservation<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Reservation Number: <input type="text" name="res_id" value="<?php echo $reservationNumber;?>">
  <span class="error">* <?php echo $reservationNumber;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

<?php

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    submit($reservationNumber,$conn);
}
function submit($reservationNumber,$conn){
  $reserve = "DELETE FROM reserve WHERE res_id = '$reservationNumber'";

  if ($conn->query($reserve) === TRUE) {
      echo "Record deleted successfully";
  } else {
      echo "Error deleting record: " . $conn->error;
  }
  $conn->close();
}
?>

</body>
</html>
