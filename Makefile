lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
install:
	composer install
validate:
	composer validate
dump:
	composer dump-autoload