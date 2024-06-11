#!/bin/bash

awk '{print $3}' ./data.txt | sort | uniq -c | sort -r | head -3