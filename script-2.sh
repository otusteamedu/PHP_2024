#!/bin/bash

awk '{print $3}' cities.txt | tail -n +2 | sort | uniq -c | sort -rn | head -n 3