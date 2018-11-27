<!DOCTYPE HTML>
<html>
<?php
  session_start();
  $server = "mysql.cs.virginia.edu";
  $user = "am7eu";
  $password = "u9KzwMUi";
  $dbname = "am7eu_dbproject";
  $mysqli = new mysqli($server, $user, $password, $dbname);
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

<?php
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    submit($_POST["firstname"], $_POST["lastname"], $_POST["dob"], $mysqli);
}
function submit($firstname, $lastname, $dob, $mysqli){
  $guest = "INSERT INTO guest (first_name, last_name, DOB) VALUES ('$firstname', '$lastname', '$dob')";
  if(mysqli_query($mysqli, $guest)){
      echo "Records inserted successfully.";
      $_SESSION['guest_id'] = $mysqli->insert_id;
      header("Location:reservation.php");
      die();
  } else{
      echo "ERROR: Could not able to execute $guest. " . mysqli_error($mysqli);
  }
}
?>

<?php
  include(dirname(__FILE__).'/components/nav.php');
?>

<div class="center-screen">
<h2 class="heading">New Guest</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="newguest.php">
  <div class="heading">
  First Name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
  <span class="error">* <?php echo $firstnameErr;?></span>
  <br><br>
  Last Name: <input type="text" name="lastname" value="<?php echo $lastname;?>">
  <span class="error">* <?php echo $lastnameErr;?></span>
  <br><br>
  DOB: <input type="text" name="dob" value="<?php echo $dob;?>">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>
  <div>
  <input type="submit" name="submit" value="Submit">
</form>
</div>



</body>
</html>
