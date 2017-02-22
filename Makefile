.PHONY: test

default: clean install

clean:
	rm -rf vendor
	rm -rf node_modules

install:
	composer install
	npm install

update:
	composer update

devel:
	grunt --force

test:
ifdef group
	./vendor/phpunit/phpunit/phpunit --group $(group)
else
	./vendor/phpunit/phpunit/phpunit
endif

fix:
	-./vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --verbose
