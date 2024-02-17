#!/bin/bash
echo $(awk '{if (NR!=1) {print $3}}' $1 | sort | uniq -c | sort -r | head -n 3)