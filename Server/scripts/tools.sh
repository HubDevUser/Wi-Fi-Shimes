#!/bin/bash   

# Function calculates number of bit in a netmask
#
mask2cidr() {
    nbits=0
    IFS=.
    for dec in $1 ; do
        case $dec in
            255) let nbits+=8;;
            254) let nbits+=7;;
            252) let nbits+=6;;
            248) let nbits+=5;;
            240) let nbits+=4;;
            224) let nbits+=3;;
            192) let nbits+=2;;
            128) let nbits+=1;;
            0);;
            *) echo "Error: $dec is not recognised"; exit 1
        esac
    done
    echo "$nbits"
}


## main ## 




# Get User IP Address

IP="ifconfig eth0 | grep -i 'inet addr:[0-9]*.[0-9]*.[0-9]*.[0-9]* '"
address=$(eval $IP)

# Collect IP Configurations 
let counter=0
for word in $address
do
if [ $counter -eq 1 ]
then
  addr=$word
fi
if [ $counter -eq 2 ]
then
  Bcast=$word
fi
if [ $counter -eq 3 ]
then
  Mask=$word
fi
    #echo $word
    #echo $counter
    let counter=counter+1
done
#echo address is $addr
#echo Broad Cast is $Bcast
#echo Mask is $Mask

#Trim from ifconfig

xmask="echo $Mask | sed  's/Mask://g'"
xm=$(eval $xmask)



xBcast="echo $Bcast | sed  's/Bcast://g'"
xb=$(eval $xBcast)


xaddr="echo $addr | sed  's/addr://g'"
xa=$(eval $xaddr)


numbits=$(mask2cidr $xm)

#echo nmap bits are: "/$numbits"
#echo address is $xa
#echo BroadCast is $xb
#echo Mask is $xm

echo "$numbits,$xa,$xb,$xm"
