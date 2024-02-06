#!/bin/bash

cat ./cities.txt | awk '{print $3}' | sort | uniq -c | sort -r | awk '{print $2}' | head -n3