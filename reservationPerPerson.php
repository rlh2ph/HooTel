<?php
$mysqli = new mysqli("mysql.cs.virginia.edu", "am7eu", "u9KzwMUi", "am7eu_dbproject");
?>
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
?>
<h2>Search by Last Name<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  lastName: <input type="text" name="last_name" value="<?php echo $lastName;?>">
  <input type="submit" name="submit" value="Submit">
</form>


<?php
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    submit($lastName,$mysqli);
}

function submit($lastName,$mysqli){
  echo "<h2>Last name searched: <h2>";
  echo $lastName;
  $query_string = "SELECT * FROM `guest` WHERE `last_name` = '$lastName' ";
  $result = $mysqli->query($query_string);
  if(!$result){
    die("Error in query:". mysqli_error($mysqli));
  }


  while ($row = mysqli_fetch_assoc($result)) {
    $space = " ";
    echo "<br>";
    $guest_id = $row['guest_id'];
    $guest_first_name = $row['first_name'];
    $guest_last_name = $row['last_name'];
    //echo "Guest ID: " . $guest_id;
    echo "<br>";
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

    $room_type = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `room` WHERE `room_num` = $room_num"));
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
}

?>

</body>
</html>
