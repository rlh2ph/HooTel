<!DOCTYPE HTML>
<html>
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

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    submit($_POST['room_num'],$mysqli);
}
?>

<?php
  include(dirname(__FILE__).'/components/nav.php');
?>

<div class="center-screen">
<h2 class="heading">Search by Room Number<h2>
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
  echo "<h2>Room searched: <h2>";
  echo $roomNumber;
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
}

?>

</body>
</html>
