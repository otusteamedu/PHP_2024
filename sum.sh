#!/bin/bash

# Function to check if a string is a number (integer or float)
is_number() {
    local num="$1"
    if [[ "$num" =~ ^[-+]?[0-9]*\.?[0-9]+$ ]]; then
        return 0
    else
        return 1
    fi
}

# Check if exactly two arguments are provided
if [ "$#" -ne 2 ]; then
    echo "Usage: $0 <number1> <number2>"
    exit 1
fi

num1=$1
num2=$2

# Validate both numbers
if ! is_number "$num1"; then
    echo "Error: '$num1' is not a valid number."
    exit 1
fi

if ! is_number "$num2"; then
    echo "Error: '$num2' is not a valid number."
    exit 1
fi

# Use bc for floating-point sum
# result=$(echo "$num1 + $num2" | bc)

# Use awk for floating-point sum
result=$(awk "BEGIN {print $num1 + $num2}")

# Print the result
echo "The sum of $num1 and $num2 is: $result"