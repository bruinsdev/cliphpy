.PHONY: test

default: clean install

clean:
	rm -rf vendor
	rm -rf node_modules

install:
	composer install
	yarn install

update:
	composer update
	yarn upgrade-interactive

devel:
	grunt --force

dockerstop:
	docker-compose stop
	docker-compose rm -f

dockercompose: dockerstop
	docker-compose up -d

test: dockercompose
	rm -rf ./test/tmp
	while ! pg_isready -h 127.0.0.1; do echo 'Waiting for PG'; sleep 2; done;
ifdef group
	./vendor/phpunit/phpunit/phpunit --group $(group)
else
	./vendor/phpunit/phpunit/phpunit
endif
	dockerstop:

fix:
	-./vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --verbose
