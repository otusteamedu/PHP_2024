#!/bin/bash

curl -k -X POST "https://localhost:9200/_bulk" -H "Content-Type: application/json" --data-binary @books.json -u elastic:otus
