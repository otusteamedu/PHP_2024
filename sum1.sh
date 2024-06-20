#!/bin/bash

# Define the two floating-point numbers
read -p "Enter the first number: " num1
read -p "Enter the second number: " num2

# check variables for first "+"

#remove "+" from the beginning of variables if any

if [[ $num1 == "+"* ]]
then
	num1=$(cut -c2- <<< $num1)
fi
if [[ $num2 == "+"* ]]
then
	num2=$(cut -c2- <<< $num2)
fi

# Use bc to calculate the sum
sum=$(echo "$num1 + $num2" | bc)

# Display the result
echo "The sum of $num1 and $num2 is: $sum"
