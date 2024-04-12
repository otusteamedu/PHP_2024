docker-up:
	@docker-compose up -d
	docker-compose exec php bash -c "export COMPOSER_HOME=/var/www && composer install"
	#docker-compose exec php bin/console doctrine:migrations:migrate -n
