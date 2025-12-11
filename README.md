# Yahoo Finance

This library is a Laravel Package to Connect to YahooFinance API.

## How to develop this project

### Composer

Update dependencies:
```shell
docker compose run --rm cli composer update
```

Composer normalization:
```shell
docker compose run --rm php-qa composer normalize
```

### Run tests

Run tests with pcov:
```shell
docker compose run --rm test ./vendor/bin/phpunit -d pcov.enabled=1
```

### Run code analysis tools (php-qa)

PHP compatibility:
```shell
docker compose run --rm php-qa phpcs --standard=.phpcs.compatibility.xml --cache=.phpcs.cache
```

Code style:
```shell
docker compose run --rm php-qa phpcs -s --colors --extensions=php
```

Fix style issues:
```shell
docker compose run --rm php-qa phpcbf -s --colors --extensions=php
```

Static analysis (phpstan):
```shell
docker compose run --rm php-qa phpstan analyse --configuration=phpstan.neon
```

Mess detector (phpmd):
```shell
docker compose run --rm php-qa phpmd ./config,./src,./tests ansi phpmd.xml --suffixes php --baseline-file phpmd.baseline.xml
```
