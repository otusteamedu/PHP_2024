awk '1 < NR && 1 < NF {print $3}' < cities.txt | sort | uniq -ci | sort -nr | head  -3