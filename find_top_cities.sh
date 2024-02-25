#!/bin/bash

awk 'NR>1{print $3}' user_data.txt | sort | uniq -c | sort -nr | head -n 3