#!/bin/bash

error_exit() {
    echo "Ошибка: $1" >&2
    exit 1
}

usage() {
    echo "Использование: $0 <число1> <число2> bc|awk"
    echo "  <число1> и <число2> — два числовых аргумента для суммирования."
    echo "  bc|awk — (необязательно) выбор метода вычисления суммы."
    exit 1
}

if [ "$#" -lt 2 ] || [ "$#" -gt 3 ]; then
    usage
fi

num1="$1"
num2="$2"
method="${3:-}"

regex='^-?[0-9]+(\.[0-9]+)?$'

if [[ ! $num1 =~ $regex ]]; then
    error_exit "'$num1' не является допустимым числом."
fi

if [[ ! $num2 =~ $regex ]]; then
    error_exit "'$num2' не является допустимым числом."
fi

calculate_with_bc() {
    echo "$num1 + $num2" | bc
}

calculate_with_awk() {
    awk "BEGIN {print $num1 + $num2}"
}

if [[ -n $method ]]; then
    case "$method" in
        bc)
            if command -v bc &> /dev/null; then
                sum=$(calculate_with_bc)
            else
                error_exit "Утилита 'bc' не установлена. Пожалуйста, установите её или выберите другой метод."
            fi
            ;;
        awk)
            if command -v awk &> /dev/null; then
                sum=$(calculate_with_awk)
            else
                error_exit "Утилита 'awk' не установлена. Пожалуйста, установите её или выберите другой метод."
            fi
            ;;
        *)
            error_exit "Неизвестный метод '$method'. Доступные методы: bc, awk."
            ;;
    esac
else
    if command -v bc &> /dev/null; then
        sum=$(calculate_with_bc)
    elif command -v awk &> /dev/null; then
        sum=$(calculate_with_awk)
    else
        error_exit "Ни утилита 'bc', ни 'awk' не установлены. Пожалуйста, установите одну из них и повторите попытку."
    fi
fi

echo "Сумма: $sum"
