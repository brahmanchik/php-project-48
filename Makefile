lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
install:
	composer install
	mkdir -p build/logs
validate:
	composer validate
dump:
	composer dump-autoload
test:
	composer exec --verbose phpunit tests

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

test-coverage-text:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-text