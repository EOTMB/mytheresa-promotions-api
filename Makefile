#!/bin/bash

DOCKER_BE = php
UID = $(shell id -u)

help:
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

setup:
	$(MAKE) build
	$(MAKE) run
	$(MAKE) prepare

run:
	$(MAKE) copy-files
	U_ID=${UID} docker compose up -d

stop:
	U_ID=${UID} docker compose stop

restart:
	$(MAKE) stop && $(MAKE) run

build:
	$(MAKE) copy-files
	U_ID=${UID} docker compose build

prepare:
	$(MAKE) copy-files
	$(MAKE) composer-install
	$(MAKE) assets
	sleep 20
	$(MAKE) migrations
	$(MAKE) fixtures

copy-files:
	cp -n .env .env.local || true
	cp -n docker-compose.yml.dist docker-compose.yml || true

composer-install:
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install --no-scripts --no-interaction --optimize-autoloader

migrations:
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php bin/console doctrine:migrations:migrate -n

fixtures:
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php bin/console doctrine:fixtures:load -n

assets:
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php bin/console asset:install

be-logs:
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} tail -f var/log/dev.log

ssh-be:
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

tests:
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php bin/phpunit --testdox

.PHONY: tests migrations copy-files
