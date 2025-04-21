#!/bin/bash

touch forumPhp.log

tail -f -n 0 forumPhp.log &
TAIL_PID=$!

php app/setup.php

php -S localhost:8000 public/index.php > /dev/null 2>&1 &
SERVER_PID=$!

trap "kill $SERVER_PID $TAIL_PID" INT

wait $SERVER_PID
