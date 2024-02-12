#!/bin/bash

file=users.txt
popularNumber=3

awk '{print $3}' $file | tail -n +2 | sort | uniq -c | sort -n | tail -$popularNumber | awk '{print $2}'