<!DOCTYPE html>
<html>
<head>
<title>Configuration Set Successfully !</title>
</head>
<body>

<h1><a href="./home.html">Camera Cop Home</a></h1>

<p>
    <a href="./listdevice.php">List Monitored Device</a> </br> </br>

</p>

<p> Configuration Set Successfully </p>

<?php

echo $_POST['DeviceOption'];

$myfile = fopen("/home/pi/device.txt","w") or die("Unable to open file !");
fwrite($myfile,$_POST['DeviceOption']);
fclose($myfile);


?>


</body>
</html>

