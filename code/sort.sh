#!/bin/env bash

awk 'FNR > 1' table.txt | awk '{ print $3 }' | sort | uniq -c | sort -r | head -n 3 | awk '{ print $2 }'
