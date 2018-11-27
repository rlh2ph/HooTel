<!DOCTYPE HTML>
<html>
<?php
$mysqli = new mysqli("mysql.cs.virginia.edu", "am7eu", "u9KzwMUi", "am7eu_dbproject");
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
  <body id="page-top">



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

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    $room_result = submit($_POST['room_num'],$mysqli);
}
?>

<?php
  include(dirname(__FILE__).'/components/nav.php');
?>
<div class="center-screen">
<h2 class="heading">Search by Room Number</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="heading">
    RoomNumber: <input type="text" name="room_num" value="<?php echo $roomNumber;?>">
    </div>
    <br><br>
    <input type="submit" name="submit" value="Submit">
    </form>
    </div>

<?php

function submit($roomNumber,$mysqli){
    $result = $mysqli->query("SELECT * FROM `reserve` WHERE `room_num` = $roomNumber LIMIT 0, 30 ");


    return $result;
}
?>
<div class="heading" style="font-size: 25px;">

<?php

$room_type = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `room` WHERE `room_num` = '$roomNumber'"));
//echo "<br>";
$room_type = $room_type['type_id'];

//echo "Room Type ID: " . $room_type;

$room_type_desc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `room_type` WHERE `type_id` = '$room_type'"));
echo "<br>";
$type_name = $room_type_desc['type_name'];
$bed_layout = $room_type_desc['bed_layout'];
$balcony = $room_type_desc['balcony'];
$smoking = $room_type_desc['smoking'];
$capacity = $room_type_desc['capacity'];
echo "Room Type: " . $type_name;
echo "<br>";
echo "Capacity: " . $capacity;
echo "<br>";
echo "Bed Layout: " . $bed_layout;
echo "<br>";
echo "Balcony: " . $balcony;
echo "<br>";
echo "Smoking: " . $smoking;
echo "<br>";

while ($row = mysqli_fetch_assoc($room_result)) {
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
?>
</div>

</body>
</html>
