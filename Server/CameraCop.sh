#!/bin/bash


#Read Device MAC
mac="cat /home/pi/device.txt"
address=$(eval $mac)
taddress=$(echo $address | grep '[0-9A-F]\{2\}\(:[0-9A-F]\{2\}\)\{5\}' | awk '{print $1}' 	)
echo Target Address is $taddress


#Read Target Email Address 
mail="cat /home/pi/email.txt"
email=$(eval $mail)
echo Target E-Mail is $email

MAILTO="$email"
export MAILTO="$email"

#Clear old packet captures
sudo rm -rf /home/Pi/Desktop/dumps/capture.pcap


#trigger another 20 millisecond capture
sudo timeout 5 sudo tshark -i mon0 -w ~/Desktop/dumps/capture.pcap
sudo chmod +777 ~/Desktop/dumps/capture.pcap

#filter frames
#echo "sudo tshark -r ~/Desktop/dumps/capture.pcap -Y "wlan.sa == $taddress  && data.len == 255"  -w ~/Desktop/dumps/filteredcapture.pcap"
sudo tshark -r ~/Desktop/dumps/capture.pcap -Y "wlan.sa == $taddress  && (data.len > 1000 || wlan.fcs_bad == 1) "  -w ~/Desktop/dumps/filteredcapture.pcap

#set filtered file permissions
sudo chmod +777 ~/Desktop/dumps/filteredcapture.pcap

files=(~/Desktop/dumps/filteredcapture.pcap)
sum=0
for f in "${files[@]}"
do
  output=`sudo tcpdump -r $f 2> /dev/null | wc -l`
  sum=$((output + sum))
done

echo "Hi number of captured camera packets is $sum"

if [ $sum -gt 0 ]
then
  printf " ${RED}ALERT:${NC} Intruder Found"
  echo " Sending e-mail to @gmail.com"
          mail -s "Camera Intruder" $email < /home/pi/alarm.txt
else
  printf "No ${RED}Intruder ${NC} Found, Triggering Another ${CYAN}Monitor${NC} \n"
fi









