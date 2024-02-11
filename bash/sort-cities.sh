FILE_FOR_SORT='cities.txt'

if ! [[ -f $FILE_FOR_SORT ]]; then
  echo "Файл '$FILE_FOR_SORT' не найден"
fi

echo "Три наиболее популярных города:"
awk '{print $3}' $FILE_FOR_SORT | tail -n +2 | sort | uniq -c | sort -rn | head -n3 | awk '{print $2}'