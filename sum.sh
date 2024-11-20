if ! [[ $1 =~ ^-?[0-9]+([.][0-9]+)?$ ]]; then
    echo 'ERROR: The first parameter is not a number'
    exit
fi

if ! [[ $2 =~ ^-?[0-9]+([.][0-9]+)?$ ]]; then
    echo 'ERROR: The second parameter is not a number'
    exit
fi

echo "$1 + $2" | bc -l
