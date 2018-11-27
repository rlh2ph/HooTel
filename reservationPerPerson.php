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
  <body>

<?php
$lastName = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (empty($_POST["last_name"])) {
    $Err = "Last name is required";
  } else {
    $lastName = test_input($_POST["last_name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
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
    $guest_result = submit($lastName,$mysqli);
}

?>


<?php
  include(dirname(__FILE__).'/components/nav.php');
?>

<div class="center-screen">
<h2 class="heading">Search by Last Name<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="heading">
  Last Name: <input type="text" name="last_name" value="<?php echo $lastName;?>">
  <br><br>
</div>
  <input type="submit" name="submit" value="Submit">
</form>
</div>


<?php


function submit($lastName,$mysqli){
  $query_string = "SELECT * FROM `guest` WHERE `last_name` = '$lastName' ";
  $result = $mysqli->query($query_string);
  if(!$result){
    die("Error in query:". mysqli_error($mysqli));
  }
  return $result;
}
?>
<div class="heading">
<?php
  while ($row = mysqli_fetch_assoc($guest_result)) {
    $guest_id = $row['guest_id'];
    $guest_first_name = $row['first_name'];
    $guest_last_name = $row['last_name'];
    //echo "Guest ID: " . $guest_id;
    echo $guest_first_name . " " . $guest_last_name;

    $room_num = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `reserve` WHERE `guest_id` = $guest_id"));
    echo "<br>";
    $room_num = $room_num['room_num'];
    //$check_in = $room_num['check_in']->format('Y-m-d');
    //$check_out = $room_num['check_out']->format('Y-m-d');
    echo "Room Number: " . $room_num;
    //echo "<br>";
    //echo "Check-In: " . $check_in;
    //echo "<br>";
    //echo "Check-Out: " . $check_out;

    $room_type = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `room` WHERE `room_num` = '$room_num'"));
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
  }

?>
</div>

</body>
</html>
