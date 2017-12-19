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





<form name="form1" method="POST" action="setdevice.php">

<?php

$output = shell_exec('/var/www/scripts/tools.sh 2>&1');
$myArray = explode(',', $output);

#Set bits
$myfile = fopen("/home/pi/bits.txt","w") or die("Unable to open file !");
$bits = $myArray[0];
fwrite($myfile,$bits);
fclose($myfile);

#Set IP
$myfile = fopen("/home/pi/ip.txt","w") or die("Unable to open file !");
$ip = $myArray[1];
fwrite($myfile,$ip);
fclose($myfile);


#Set Broadcast Address
$myfile = fopen("/home/pi/cast.txt","w") or die("Unable to open file !");
$cast = $myArray[2];
fwrite($myfile,$cast);
fclose($myfile);

#Set Subnet Mask
$myfile = fopen("/home/pi/mask.txt","w") or die("Unable to open file !");
$mask = $myArray[3];
fwrite($myfile,$mask);
fclose($myfile);

$command = "nmap -sP $ip/$bits";
exec($command,$out,$ret_var);
$targets = array();
foreach ($out as $value){
  if(preg_match("/Nmap scan/",$value)) {
     $Device = preg_replace("/Nmap scan report for /",'',$value);
     $targets[] = $Device;
  }
}


echo "<select name='DeviceOption' size='1'>";
echo "Select A Device to Monitor:" ;
echo "</br>";
echo "</br>";
 

  foreach($targets as $target) {
	print_r($target);
	echo "</br>";
	$OS="";
	$OScommand = "sudo -u root -S /usr/bin/nmap  -O $target";
	exec($OScommand,$OS,$ret_var);
	
	foreach($OS as $DeviceDetails){

		if(preg_match("/OS details:/",$DeviceDetails)) {
	        print("$DeviceDetails");
                echo "</br>";
	        }

	       if(preg_match("/MAC Address:/",$DeviceDetails)) {
  	         $DeviceMan = preg_replace("/MAC Address:/",'',$DeviceDetails);  
 	         print("$DeviceMan");
	         echo "<option name='DeviceOption' value='$DeviceMan'>" . $DeviceMan  . "</option>" ;
	         echo "</br>";
              }
       }
    echo "</br>";
  }

echo "</select>";

echo "</br>";

?>

<input type="submit" value="Configure Device" value="DeviceOption" />

</body>
</html>