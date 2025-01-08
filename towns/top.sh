#!/bin/bash

echo $(awk '{print $3}' towns.txt | sort | uniq -c | sort -nr | head -n 3)
