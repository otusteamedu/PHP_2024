curl -k "$ELASTICSEARCH_HOST/_bulk" -H "Content-Type: application/json" --data-binary @books.json