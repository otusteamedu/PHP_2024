#!/bin/bash

if [ -z $2 ]; then
    count=3
else
    count=$2
fi

cat $1 | tail -n +2 | awk '{print $3}' | grep -v '^$'| sort | uniq | while read city; do
	summ=$(cat $1 | tail -n +2 | grep $city | awk '{sum += $4;} END {print sum;}')
	echo $city $summ
done | sort -r -n -k2 | head -$count