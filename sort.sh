#!/bin/bash

awk 'NR > 1 {print $3}' ./cities.txt | sort -k3 | uniq -c | sort -k1 -r | awk '{print $2}' | head -3
