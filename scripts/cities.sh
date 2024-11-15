#!/bin/bash

awk '{print $3}' data.txt | tail -n +2 | sort | uniq -c | sort -nr | head -n 3
