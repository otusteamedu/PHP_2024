#!/usr/bin/env bash

echo $(awk '{RS="\n\n"}{print $3}' $1 | tail -n +2 | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}')
