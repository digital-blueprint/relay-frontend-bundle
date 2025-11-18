# Changelog

## v0.1.16

* Drop support for api-platform 3
* Dependency cleanups

## v0.1.15

* Add support for api-platform 4.1+ (in addition to 3.4)

## v0.1.14

* Allow specifying dynamic frontend roles via the bundle configuration

    ```yaml
    # config/packages/dbp_relay_frontend.yaml
    dbp_relay_frontend:
        roles:
            ROLE_CUSTOM: '<some expression>'
    ```


## v0.1.13

* Drop support for PHP 8.1
* Drop support for Psalm

## v0.1.12 

* Call UserProvider parent constructor

## v0.1.11

* Add event UserRolesRequestedEvent which allows subscribers to add roles for the current user

## v0.1.10

* Port to PHPUnit 10
* Port from doctrine annotations to PHP attributes

## v0.1.9

* Add support for api-platform 3.2

## v0.1.8

* Add support for Symfony 6

## v0.1.7

* Drop support for PHP 7.4/8.0

## v0.1.6

* Drop support for PHP 7.3

## v0.1.5

* Port to the new api-platform metadata system

## v0.1.4

* Update to api-platform v2.7

## v0.1.3

* Moved to GitHub

## v0.1.2

* Remove usage of deprecated core bundle functionality

## v0.1.1

* Support for PHP 8.0/8.1

## v0.1.0

* Initial release
