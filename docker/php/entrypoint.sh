#!/bin/sh
service cron start
sudo service supervisor start

set -e

## set host.docker.internal to hosts file for xdebug reasons
HOST_DOMAIN="host.docker.internal"
if ! ping -q -c1 $HOST_DOMAIN > /dev/null 2>&1
then
  HOST_IP=$(ip route | awk 'NR==1 {print $3}')
  # shellcheck disable=SC2039
  echo "$HOST_IP\t$HOST_DOMAIN" >> /etc/hosts
fi

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"
