#!/usr/bin/awk -f

{
    sum = 0

    for (i = 1; i <= NF; ++i) {
        if ($i !~ "^[+-]?[0-9]+(\\.[0-9]+)?$") {
            printf "Error: '%s' is not a number\n",$i > "/dev/stderr"
            exit 1
        }

        sum += $i
    }

    print sum
}

