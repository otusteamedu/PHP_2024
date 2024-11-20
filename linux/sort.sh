#!/bin/bash

FN=$1

 awk 'FNR>1 {print $3}' $FN | sort | uniq -c | sort -r| head -n 3| awk '{print$2}'