#!/bin/bash
tail -n +2 list_cities | awk {'print $3'} | sort | uniq -c | sort -k 1,1r | head -3 | awk {'print $2'}
