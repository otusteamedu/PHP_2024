#! /usr/bin/env bash
clear

if [[ $# -ne 1 ]]
then
echo "Invalid number of arguments"
exit 1
fi

tail -n +2 $1 | awk '!/^$/{print $3}' | sort | uniq -ci | sort -r | awk '{print NR,$2}' | head -3

exit 0