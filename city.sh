#!/bin/sh

city=$(awk '{print $3}' city.txt | tail -n +2 | sort | uniq -c | sort -r | head -3)
echo $city