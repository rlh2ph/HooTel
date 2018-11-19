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
$roomNumber = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (empty($_POST["room_num"])) {
    $Err = "Room number is required";
  } else {
    $roomNumber = test_input($_POST["room_num"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$roomNumber)) {
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
<h2>Search by Room Number<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  RoomNumber: <input type="text" name="room_num" value="<?php echo $roomNumber;?>">
  <input type="submit" name="submit" value="Submit">
</form>

<?php
echo "<h2>Your input<h2>";
echo $roomNumber;
?>

<?php
  $result = $mysqli->query("SELECT * FROM `reserve` WHERE `room_num` = $roomNumber LIMIT 0, 30 ");

  while ($row = mysqli_fetch_assoc($result)) {
    $space = " ";
    echo "<br>";
    $id = $row['guest_id'];
    echo "Guest ID: " . $id;
    echo "<br>";
    $info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `guest` WHERE `guest_id` = $id"));
    echo $info['first_name'] . $space . $info['last_name'];

  }
?>

</body>
</html>
