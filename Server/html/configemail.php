<!DOCTYPE html>
<html>
<head>
<title>Camera Cop Home Page</title>
</head>
<body>

<h1><a href="./home.html">Camera Cop Home</a></h1>

<p>
    <a href="./listdevice.php">List Monitored Device</a> </br>  </br> 
    <a href="./configdevice.php">Configure Device to Monitor</a> </br> </br> 
    <a href="./configemail.php">Configure Email Notification</a> </br> </br>
</p>

<?php

$email = file_get_contents('/home/pi/email.txt');

  if(!isset($_POST['email'])) {
echo "Current Configuration Set to : $email";
echo "</br>";
}
?>

<form name="form1" method="POST" action="configemail.php">

<input type="text" value="" name="email" />
<input type="submit" value="Set New E-Mail" value="email" />

</form>

<?php

 if(isset($_POST['email'])) {
 $email = $_POST['email'];
 $myfile = fopen("/home/pi/email.txt","w") or die("Unable to open file !");
 fwrite($myfile,$_POST['email']);
  fclose($myfile);
   print("email set to $email");
}




?>

</body>
</html>