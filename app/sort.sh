#!/bin/bash

cat ./cities.txt | awk 'NR>1 {print $3}' | sort | uniq -c | sort -r | awk '{print $2}' | head -n3
