#!/usr/bin/env bash

is_float()  {
    case ${1#[-+]} in
        '' | *. | .* | *[!0-9.]* | *.*.* ) return 1 ;;
    esac
}

sum=0

for var in "$@"; do
    if ! is_float $var; then
        printf '%s\n' "Error: '$var' is not a number" >&2
        exit 1
    fi

    sum=$(echo "$sum $var" | awk '{ print $1 + $2 }')
done

echo $sum

