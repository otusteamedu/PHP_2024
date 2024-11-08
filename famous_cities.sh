if [ ! -f $1 ]; then
    echo "File $1 not found!"
else
    awk -F" " 'NR>1 { print $3 }' $1 | sort -f | uniq -ic | sort -r | head -n 3 | awk -F" " '{ print $2 }'
fi
