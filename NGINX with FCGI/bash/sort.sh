#!/bin/bash
awk '!/id/' text.txt | grep . | sort -k 4n | head -3