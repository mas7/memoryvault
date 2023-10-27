#!/bin/bash
while true; do
  fswatch -o ./app ./tests ./routes ./resources | read &&
  clear &&
  ./vendor/bin/sail artisan test
done
