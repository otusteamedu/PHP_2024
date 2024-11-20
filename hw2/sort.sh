#!/bin/bash

cat > data.txt <<EOF
id user city phone
1 test Moscow 1234123
2 test2 Saint-P 1232121
3 test3 Tver 4352124
4 test4 Milan 7990923
5 test5 Moscow 908213
EOF

awk 'NR>1 {print $3}' data.txt | sort | uniq -c | sort -nr | head -n 3
