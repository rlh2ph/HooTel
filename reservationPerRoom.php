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
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    submit($roomNumber,$mysqli);
}

function submit($roomNumber,$mysqli){
  echo "<h2>Room searched: $roomNumber<h2>";
  $result = $mysqli->query("SELECT * FROM `reserve` WHERE `room_num` = $roomNumber LIMIT 0, 30 ");
  while ($row = mysqli_fetch_assoc($result)) {
    $res_id = $row['res_id'];
    $space = " ";
    echo "<br>";
    $id = $row['guest_id'];
    //$check_in = $result['check_in'];
    //$check_out = $result['check_out'];
    //echo "Guest ID: " . $id;
    //echo "<br>";
    $res_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `reserve` WHERE `res_id` = $res_id"));
    $info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `guest` WHERE `guest_id` = $id"));
    $check_in = $res_info['check_in'];
    $check_out = $res_info['check_out'];
    echo $info['first_name'] . $space . $info['last_name'];
    echo "<br>";
    echo date("m/d/Y", strtotime($check_in)) . " - " . date("m/d/Y", strtotime($check_out));
    echo "<br>";
  }
}

?>

</body>
</html>
