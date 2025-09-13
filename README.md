# Yahoo Finance

This library is a Laravel Package to Connect to YahooFinance API.

## Tools

Composer

```shell
    docker compose run cli composer install
```

```shell
    docker compose run php-qa composer normalize
```

Tests

```shell
    docker compose run test php -d pcov.enabled=1 ./vendor/bin/phpunit
```

QA

```shell
    docker compose run php-qa phpcs -s --colors --extensions=php
```

```shell
    docker compose run php-qa phpcbf -s --colors --extensions=php
```

```shell
    docker compose run php-qa phpcs --standard=.phpcs.compatibility.xml --cache=.phpcs.cache --report=junit --report-file=report.xml
```