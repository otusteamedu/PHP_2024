#!/bin/bash

awk '{print $3}' users_city.txt | sort | uniq -c | sort -nr | head -n 3