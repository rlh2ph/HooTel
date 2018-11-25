<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>


  <h2>Search by Room Number<h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Last name: <input type="text" name="lastname" value="<?php echo $lastname;?>">
    <span class="error">* <?php echo $lastnameErr;?></span>
    <br><br>
    DOB: <input type="text" name="dob" value="<?php echo $dob;?>">
    <span class="error">* <?php echo $dobErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">

  </form>



</body>
</html>
