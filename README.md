# Yahoo Finance

This library is a Laravel Package to Connect to YahooFinance API.

## How to develop this project

### Composer

Update dependencies:
```shell
docker compose run -it --rm test composer update
```

Composer normalization:
```shell
docker compose run -it --rm php-qa composer normalize
```

### Run code analysis tools (php-qa)

PHP compatibility:
```shell
docker compose run -it --rm php-qa phpcs --standard=.phpcs.compatibility.xml --cache=.phpcs.cache
```

Code style:
```shell
docker compose run -it --rm php-qa phpcs -s --colors --extensions=php
```

Fix style issues:
```shell
docker compose run -it --rm php-qa phpcbf -s --colors --extensions=php
```

Static analysis (phpstan):
```shell
docker compose run -it --rm php-qa phpstan analyse --configuration=phpstan.neon
```

Regenerate the phpstan baseline:
```shell
docker compose run -it --rm php-qa phpstan analyse --configuration=phpstan.neon --generate-baseline=phpstan-baseline.neon
```

Mess detector (phpmd):
```shell
docker compose run -it --rm php-qa phpmd analyze
```

Regenerate the phpmd baseline:
```shell
docker compose run -it --rm php-qa phpmd analyze --generate-baseline
```

### Run tests

Run tests:
```shell
docker compose run -it --rm test ./vendor/bin/phpunit
```

Run tests with coverage:
```shell
docker compose run -it --rm test ./vendor/bin/phpunit --coverage-text
```

### Run the whole PHP suite

Run every PHP check and the test suite in sequence (stops at the first failure):
```shell
docker compose run -it --rm test composer update \
  && docker compose run -it --rm php-qa composer normalize \
  && docker compose run -it --rm php-qa phpcs --standard=.phpcs.compatibility.xml --cache=.phpcs.cache \
  && docker compose run -it --rm php-qa phpcs -s --colors --extensions=php \
  && docker compose run -it --rm php-qa phpstan analyse --configuration=phpstan.neon \
  && docker compose run -it --rm php-qa phpmd analyze \
  && docker compose run -it --rm test ./vendor/bin/phpunit
```
