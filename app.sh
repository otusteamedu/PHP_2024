#!/bin/bash
docker run -it --rm -v ./code:/code -w $PWD chat/php php $@
