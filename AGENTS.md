# AGENTS.md — dejwcake/yahoo-finance

Laravel client for the Yahoo Finance API at `yfapi.net` (stock quotes and history). Composer
`dejwcake/yahoo-finance`, namespace `DejwCake\YahooFinance`. README.md shows consumer usage.

## Layout

- `YahooFinanceServiceProvider` — merges/publishes `config/yahoo-finance.php` (`apiUrl`,
  `timeout`, `apiKey` from `YAHOO_FINANCE_API_KEY`) and binds `YahooFinanceClient` as a singleton
  on a Guzzle client carrying the `X-API-KEY` header.
- `YahooFinanceClient::create($httpClient, $logger)` — the only constructor (private `__construct`,
  PSR-17 factories via `php-http/discovery`). One public method per endpoint:
  `getStockQuote()`, `getStockHistory()`; `$fetch` is `FETCH_OBJECT` (models) or `FETCH_RESPONSE`.
- `src/ApiClient/` — generic, API-agnostic layer: abstract `Client::executeEndpoint()`,
  `EndPoints\BaseEndpoint` (status → exception mapping, response parsing), `Exceptions\`,
  model contracts. Keep Yahoo specifics out of it.
- `src/EndPoints/` — one class per API call: URI, method, query parameters,
  `transformResponseBody()` into response models.
- `src/Models/` — `RequestModels\*Request` (input), `ResponseModels\*` (output) built by
  `ResponseModels\Factories\*Factory` from JSON, and backed `Enums\` (`Interval`, `Range`,
  `Region`, `Lang`) with `EnumAsArrayTrait` / `EnumForSelectTrait`.
- A new API call = request model + endpoint + response model and factory + a method on
  `YahooFinanceClient` + tests for each.

## Commands

Everything runs in Docker from the package root — never against a host PHP. The full,
copy-pasteable list (composer, every QA tool and
the "whole PHP suite" one-liner) is in **README.md → "How to develop this project"**.
The ones you need most:

```shell
docker compose run --rm test composer update
docker compose run --rm test ./vendor/bin/phpunit
docker compose run --rm php-qa phpcs -s --colors --extensions=php
docker compose run --rm php-qa phpcbf -s --colors --extensions=php       # auto-fix style
docker compose run --rm php-qa phpstan analyse --configuration=phpstan.neon
docker compose run --rm php-qa phpmd analyze
docker compose run --rm php-qa phpcs --standard=.phpcs.compatibility.xml --cache=.phpcs.cache
docker compose run --rm php-qa composer normalize
```

A change is done when phpcs, phpstan, phpmd and the test suite are green. CI runs the tests on
every supported PHP version (8.2–8.5).

## Code conventions

- PHP `^8.2`, Laravel 10–12 (`illuminate/*`). Code must run on **8.2**: no typed class constants
  (8.3), no `json_validate()`, nothing newer — PHPCS Compatibility checks from 8.2 up. Every file
  starts with `declare(strict_types=1);`.
- **No Facades** — inject contracts through the constructor.
- **No helpers**, with these exceptions: `trans()` / `__()` are allowed everywhere; `app()` only
  where DI is genuinely hard to provide. (`env()` belongs in `config/` only.)
- Constructor property promotion. `final` classes and `readonly` wherever possible — prefer a
  `final readonly class`, otherwise readonly properties. A readonly property is public rather than
  hidden behind a getter. `ApiClient` base classes and exceptions that are extended stay non-final.
- Always import with `use`; never inline `\Fully\Qualified\Names`.
- Alias the colliding `Repository` contracts:
  `use Illuminate\Contracts\Config\Repository as Config;`,
  `use Illuminate\Contracts\Cache\Repository as Cache;`.
- Name a property after its type: `GetStockQuoteRequest $getStockQuoteRequest`, not `$request`.
- Build strings with `sprintf()` — no `"{$var}"` interpolation and no `.` concatenation.
- Before adding a native type to an overriding property/parameter, check the parent. If the parent
  is untyped, the child must stay untyped too.
- Fix new phpstan/phpmd findings in code. Baselines are for accepted, existing debt only — inspect
  the baseline diff before committing it.

## Testing conventions

- Plain PHPUnit (`^11.5 || ^12.0`), no Testbench. Test namespaces mirror `src/`.
- `tests/Unit/` — endpoints, request models, response factories, each in isolation.
  `tests/Functional/YahooFinanceClientTest.php` — the client end to end over a mocked PSR-18
  client returning recorded JSON bodies. No real API calls.
- Several tested methods of one class → a directory named after the class with one
  `<Method>Test.php` per method.
- Assertions are static: `self::assert*()`.
- Long recorded JSON fixtures are inline with `// phpcs:disable …LineTooLong`; keep them real
  API responses, trimmed rather than invented.

## Versioning

The package is on **2.x**: work happens on `v2`, and `main` is fast-forwarded to it once CI is
green. `main` is protected — required checks on the exact commit, no direct pushes. Widening the
supported PHP/Laravel range is a minor version; dropping one, or changing the public client
methods, models or enums, is a major.
