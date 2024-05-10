# Elasticsearch 8.12.2
## Getting started
### 1.0 up docker-compose.yml
```bash
docker compose up -d --build
```
### 1.1 copy crt to local machine
```bash
docker cp elasticsearch:/usr/share/elasticsearch/config/certs/http_ca.crt .
```
### 1.2 make curl call to elasticsearch to ensure that container is running
```bash
curl --cacert http_ca.crt -u elastic:{YOUR_PASSWORD} https://localhost:9200
```
## Request examples
### Add new indexes
```bash
curl -X POST --cacert http_ca.crt -u elastic:{YOUR_PASSWORD} https://localhost:9200/otus-shop/_bulk -H "Content-Type: application/json" --data-binary @./books.js
```

## Usage
### Params
| name     | type    | description        |
| -------- | ------- | ------------------ |
| gt_price | integer | greater than price |
| lt_price | integer | less than price    |
| search   | string  | search query       |
### Examples
```bash
php app.php
```
```bash
php app.php --lt_price=2000 --search=рыцори
```