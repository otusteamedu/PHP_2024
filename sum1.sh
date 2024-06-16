#!/bin/bash

# Define the two floating-point numbers
read -p "Enter the first number: " num1
read -p "Enter the second number: " num2

# Use bc to calculate the sum
sum=$(echo "$num1 + $num2" | bc)

# Display the result
echo "The sum of $num1 and $num2 is: $sum"
