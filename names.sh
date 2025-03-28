#!/bin/bash

awk '{print $3}' names.list | sort | uniq -c | sort -nr | head -n 2 

