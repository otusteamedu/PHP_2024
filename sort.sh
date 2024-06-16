cat users.txt | awk 'NR > 2 { print $3 }' | sort -nr | uniq -c | sort -k1 -r | head -4 | tail -n +2
