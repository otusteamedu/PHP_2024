#!/bin/bash
set -e

psql "$POSTGRES_DB" < /docker-entrypoint-initdb.d/init.sql
psql "$POSTGRES_DB" < /docker-entrypoint-initdb.d/functions.sql