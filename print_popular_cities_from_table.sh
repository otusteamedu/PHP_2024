#!/bin/bash

awk '{print $3}' table.list | sort | uniq -c | sort -nr | head -n 2