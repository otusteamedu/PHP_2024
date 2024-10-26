.PHONY: up down exec shell init migrate seed search-post-with-id-1 search-post-with-id-100 search-all-posts

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

find-post-with-id-1:
	make exec ARGS='php bin/console blog:posts:find-by-id 1'

find-post-with-id-100:
	make exec ARGS='php bin/console blog:posts:find-by-id 100'

list-posts:
	make exec ARGS='php bin/console blog:posts:list'

list-posts-by-pages-1:
	make exec ARGS='php bin/console blog:posts:list --page_size=5'

list-posts-by-pages-2:
	make exec ARGS='php bin/console blog:posts:list --page_size=5 --page_number=2'
