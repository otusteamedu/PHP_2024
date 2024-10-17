.PHONY: up down exec shell init create-event-1 create-event-2 create-event-3 find-event-1 find-event-2 find-event-3 clear-events

up:
	docker-compose up -d --build

down:
	docker-compose down

exec:
	docker exec -it otus-analytics-php-cli $(ARGS)

shell:
	make exec ARGS=bash

init: clear-events create-event-1 create-event-2 create-event-3

create-event-1:
	make exec ARGS='php bin/console analytics:events:create "{priority: 1000, name: event_1, conditions: {param1 = 1}}"'

create-event-2:
	make exec ARGS='php bin/console analytics:events:create "{priority: 2000, name: event_2, conditions: {param1 = 2, param2 = 2}}"'

create-event-3:
	make exec ARGS='php bin/console analytics:events:create "{priority: 3000, name: event_3, conditions: {param1 = 1, param2 = 2}}"'

find-event-1:
	make exec ARGS='php bin/console analytics:events:find "{conditions: {param1 = 1}}"'

find-event-2:
	make exec ARGS='php bin/console analytics:events:find "{conditions: {param2 = 2}}"'

find-event-3:
	make exec ARGS='php bin/console analytics:events:find "{conditions: {foo = bar}}"'

clear-events:
	make exec ARGS='php bin/console analytics:events:clear'
