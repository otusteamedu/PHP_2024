#!/bin/bash
awk 'NR!=1 && NF {print $3}' tab.txt | sort | uniq -c | sort -nr |head -n 3