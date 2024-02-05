#!/bin/bash

cut -d' ' -f3 cities.txt | sort | uniq -c | sort -rn | head -n3