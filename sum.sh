#!/bin/bash

# Проверяем, передано ли два аргумента
if [ "$#" -ne 2 ]; then
  echo "Необходимо передать 2 аргумента:число в формате: $0 agr1:float arg2:float"
  exit 1
fi

# Присваиваем аргументы переменным
num1=$1
num2=$2

# Проверяем, являются ли аргументы числами
if ! [[ $num1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]] || ! [[ $num2 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]; then
  echo "Оба аргумента должны быть числами"
  exit 1
fi

# Проверяем наличие установленного пакета bc
if ! command -v bc &> /dev/null; then
  echo "Пакета bc не найден. Установка пакета..."
  # Установка пакета bc в зависимости от дистрибутива
  case "$(uname -s)" in
    *"Ubuntu"* | *"Debian"* | *"Mint"*)
      sudo apt-get update && sudo apt-get install -y bc;;
    *"CentOS"* | *"Red Hat"* | *"Fedora"* | *"RHEL"*)
      sudo yum install -y bc;;
    *"Arch"* | *"Manjaro"* | *"Arch Linux"*)
      sudo pacman -S --noconfirm bc;;
    *"Darwin"*)
      brew install bc;;
    *)
      echo "Неподдерживаемая операционная система. Установите пакет bc вручную."
      exit 1
      ;;
  esac
fi

# Вычисляем сумму
sum=$(echo "scale=2; $num1 + $num2" | bc)

# Выводим сумму
echo $sum
