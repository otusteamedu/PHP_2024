#!/bin/bash

docker-compose down -v --remove-orphans
docker-compose up -d --build

