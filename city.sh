#!/bin/bash

echo "$(awk 'NR > 1 { print $3 }' table.txt | sort | uniq -c | sort -r | head -n 3 | awk "{ print $1 $2 }")"
