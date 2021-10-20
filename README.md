# DBP Relay Frontend Bundle

[GitLab](https://gitlab.tugraz.at/dbp/relay/dbp-relay-frontend-bundle) | [Packagist](https://packagist.org/packages/dbp/relay-frontend-bundle)

This bundle contains APIs mostly useful for frontend apps. It is a required dependency
for all DBP frontend apps.

## Bundle installation

You can install the bundle directly from [packagist.org](https://packagist.org/packages/dbp/relay-frontend-bundle).

```bash
composer require dbp/relay-frontend-bundle
```

## Integration into the Relay API Server

* Add the bundle to your `config/bundles.php` in front of `DbpRelayCoreBundle`:

```php
...
Dbp\Relay\FrontendBundle\DbpRelayFrontendBundle::class => ['all' => true],
Dbp\Relay\CoreBundle\DbpRelayCoreBundle::class => ['all' => true],
];
```

* Run `composer install` to clear caches
