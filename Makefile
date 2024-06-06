PORT ?= 8080

start-app:
	php -S localhost:${PORT} -t public