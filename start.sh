#!/bin/bash
# 
# Script used for starting the app.
# It sets up the app.
# Then shows the log files.
# Upon Interrupt, it quits all spawned processes.
# 

# Complete path for the log file
LOG_FILE_PATH="forumPhp.log"

# Ensures log file exists
touch $LOG_FILE_PATH

# Watches the log file. Does not show already written contents
tail -f -n 0 $LOG_FILE_PATH &
TAIL_PID=$!

# Sets up the app
php app/setup.php

# Starts the server, dumps standard php logs to null
php -S localhost:8000 public/index.php  2>&1 &
SERVER_PID=$!

trap "kill $SERVER_PID $TAIL_PID" INT

# Waits till server is ended
wait $SERVER_PID
