<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

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

<?php
include(dirname(__FILE__).'/components/nav.php');
 ?>

 <?php
 $res_id = $_GET["id"];
 echo $res_id;
  ?>

<!-- <h2>Cancel Reservation<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Reservation Number: <input type="text" name="res_id" value="<?php echo $reservationNumber;?>">
  <span class="error">* <?php echo $reservationNumber;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form> -->

<?php

submit($res_id,$conn);

function submit($reservationNumber,$conn){
  $reserve = "DELETE FROM reserve WHERE res_id = '$reservationNumber'";

  if ($conn->query($reserve) === TRUE) {
      echo "Record deleted successfully";
      header("Location:reservationPerPerson.php");
  } else {
      echo "Error deleting record: " . $conn->error;
  }
  $conn->close();
}
?>

</body>
</html>
