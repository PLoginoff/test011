#!/usr/bin/env bash
#Fake sendmail script

name=$1/fakesendmail.log
while read line
do
  echo $line >> $name
done
exit 0
