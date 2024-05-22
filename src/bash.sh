#!/bin/bash

export $(grep -v '^#' .env | xargs)

curl -k -X POST "https://localhost:9200/_bulk" -H "Content-Type: application/json" --data-binary @dump/books.json -u elastic:1234