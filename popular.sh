FILE=$1
COLUMN=$2

COLUMN_NUM=$(awk -v word="$COLUMN" '{for(i=1;i<=NF;i++)if($i==word){print i;exit}}' $FILE)

awk -v col="$COLUMN_NUM" 'NR>1{print $col}' $FILE | sort | uniq -c | sort -r | head -3 | awk '{print $2}'
