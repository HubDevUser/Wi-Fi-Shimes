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

 
 
   $device = file_get_contents('/home/pi/device.txt');

   print("Camera Cop is Configured to Monitor $device");





?>

</body>
</html>