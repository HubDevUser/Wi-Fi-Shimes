#!/bin/bash
ip=$1
bits=$2
nmap="nmap -sP $ip/$bits"
#echo $nmap
map=$(eval $nmap)
echo $map