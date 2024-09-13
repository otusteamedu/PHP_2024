FROM ubuntu

RUN apt-get update && apt-get install -y memcached

CMD ["-m", "128"] # Set the user to run Memcached daemon

USER daemon

ENTRYPOINT memcached
