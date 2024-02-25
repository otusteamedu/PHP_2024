#!/bin/bash

echo $(tail -n +2 $1 | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}')