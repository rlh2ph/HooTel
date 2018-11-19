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

//<?php
//echo "<h2>Your input<h2>";
//echo $reservationNumber;
//$sql = "DELETE FROM `am7eu_dbproject`.`reserve` WHERE `reserve`.`res_id` = $reservationNumber";

//if ($conn->query($sql) === TRUE) {
//    echo "Record deleted successfully";
//} else {
//    echo "Error deleting record: " . $conn->error;
//}

//$conn->close();
//?>

<h2>Cancel Reservation<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Reservation Number: <input type="text" name="res_num" value="<?php echo $reservationNumber;?>">
  <span class="error">* <?php echo $reservationNumber;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
