#!/bin/bash

isError=false;
isAwk=false;

for i in $@
do
  if ! [[ "$i" =~ (^(\-?)[0-9]+(\.[0-9]+)?$) ]]
  then
     isError=true;
  else
    if [[ "$i" =~ (\.) ]]
    then
      isAwk=true;
    fi
  fi
done

if [ $isError = true ]
then
  echo "Error in arguments";
  exit 1;
else
  if [ $isAwk = true ]
  then
    sum=$(awk 'BEGIN { for(i = 1; i < ARGC; i++) { sum+=ARGV[i]; } print sum;}' $@);
  else
    for i in $@
      do
        sum=$((sum+i))
      done
  fi
fi

echo $sum;
exit 0