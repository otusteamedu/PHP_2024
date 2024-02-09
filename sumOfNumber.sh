#!/bin/bash
echo "$1 $2" | 
awk '{
    if (length($1) == 0) {
        print "Не передан первый параметр";
        exit 1;
    }
    if (length($2) == 0) {
        print "Не передан второй параметр";
        exit 2;
    }
    print $1+$2;
    exit 0;
}';