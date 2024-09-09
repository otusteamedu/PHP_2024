#!/bin/bash

awk 'NR > 1 && $3 != "" {print $3}' file | sort | uniq -c | sort -nr | head -n 3