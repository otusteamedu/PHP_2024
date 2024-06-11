#!/bin/bash
status="$(dpkg-query -W --showformat='${db:Status-Status}' "bc" 2>&1)"
if [ ! $? = 0 ] || [ ! "$status" = installed ]; then
  echo "Please install bc utility";exit 1
fi
re='^[+-]?[0-9]+\.?[0-9]*$'
for var in "$@"
do
    if ! [[ $var =~ $re ]] ; then
       echo "error: Not a number argument: $var"; exit 1
    fi
done

echo $1 + $2 | bc