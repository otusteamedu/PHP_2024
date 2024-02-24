build:
	docker build . -f docker/php-app/Dockerfile -t chat-app

start-server:
	docker run --name chat-app-server --rm -v ./chat-app:/chat-app chat-app start-server

start-client:
	docker run -i --name chat-app-client --rm -v ./chat-app:/chat-app chat-app start-client

force-stop-server:
	docker stop chat-app-server

force-stop-client:
	docker stop chat-app-client
