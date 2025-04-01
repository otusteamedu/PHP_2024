#!/bin/bash

if ! command -v bc &> /dev/null; then
    echo "Утилита bc не найдена. Устанавливаем..."
    if [[ "$(uname)" == "Linux" ]]; then
        sudo apt-get update && sudo apt-get install -y bc
    elif [[ "$(uname)" == "Darwin" ]]; then
        brew install bc
    else
        echo "Ошибка: Не удалось установить bc. Установите вручную."
        exit 1
    fi
fi

if [ $# -ne 2 ]; then
    echo "Ошибка: Необходимо передать ровно 2 параметра"
    echo "Пример: $0 123 45.67"
    exit 1
fi

is_number() {
    [[ "$1" =~ ^-?[0-9]+(\.[0-9]+)?$ ]]
}

if ! is_number "$1" || ! is_number "$2"; then
    echo "Ошибка: Оба параметра должны быть числами (пример: 123 или -45.67)"
    exit 1
fi

sum=$(echo "$1 + $2" | bc)
echo "Сумма чисел $1 и $2 = $sum"