#!/bin/bash

awk '{print $3}' ./data.txt | tail -n+2 | sort | uniq -c | sort -r | head -3