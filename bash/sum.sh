#!/bin/bash

FIRST_ARGUMENT=$1
SECOND_ARGUMENT=$2

if [ $# -ne 2 ]
then
    echo "Error: The script expects two arguments."
    exit 1
fi

if ! command -v bc &> /dev/null
then
    echo "Error: The 'bc' utility is required to run this script."
    read -p "Would you like to install bc? (y/n): " answer
    if [[ $answer = "y" ]]
    then
        sudo apt-get install bc
        if [ $? -ne 0 ]
        then
            echo "Failed to install 'bc'. Please install it manually."
            exit 1
        fi
    else
        echo "'bc' is not installed. Exiting."
        exit 1
    fi
fi

is_number()
{
    if [[ $1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]
    then
        return 0
    else
        return 1
    fi
}

if ! is_number "$FIRST_ARGUMENT"
then
    echo "Error: The first argument '$FIRST_ARGUMENT' is not a number."
    exit 1
fi

if ! is_number "$SECOND_ARGUMENT"
then
    echo "Error: The second argument '$SECOND_ARGUMENT' is not a number."
    exit 1
fi

SUM=$(echo "$FIRST_ARGUMENT + $SECOND_ARGUMENT" | bc)

echo 'Sum: '$SUM
