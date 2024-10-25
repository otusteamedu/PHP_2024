.PHONY: up down exec shell

up:
	docker-compose up -d --build

down:
	docker-compose down

exec:
	docker exec -it otus-blog-php-cli $(ARGS)

shell:
	make exec ARGS=bash

init: migrate seed

migrate:
	make exec ARGS='php bin/console database:import /var/www/otus/hw13/database/migrations/blog-ddl.sql'

seed:
	make exec ARGS='php bin/console database:import /var/www/otus/hw13/database/migrations/blog-dml.sql'

search-post-with-id-1:
	make exec ARGS='php bin/console blog:posts:search --post_id=1'

search-post-with-id-100:
	make exec ARGS='php bin/console blog:posts:search --post_id=100'

search-all-posts:
	make exec ARGS='php bin/console blog:posts:search'

create-post:
	make exec ARGS='php bin/console blog:posts:create "#?" "Some content..." "draft"'

create-post-with-comments:
	make exec ARGS='php bin/console blog:posts:create "#?" "Some content..." "draft" "Comment #1, Comment #2, Comment #3, Comment #4"'

