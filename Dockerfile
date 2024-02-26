FROM alpine

RUN apk add --no-cache bash

COPY sum.sh /sum.sh
COPY cities.txt /cities.txt
COPY cities_top.sh /cities_top.sh

RUN chmod +x /sum.sh
RUN chmod +x /cities_top.sh

ENTRYPOINT ["/bin/bash"]
