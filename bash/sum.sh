#!/bin/bash

command -v bc >/dev/null 2>&1 || { echo "Please install bc" >&2; exit 1; }
re='^[+-]?[0-9]+\.?[0-9]*$'
for var in "$@"
do
    if ! [[ $var =~ $re ]] ; then
       echo "error: Not a number argument: $var"; exit 1
    fi
done

echo $(($1 + $2)) | bc