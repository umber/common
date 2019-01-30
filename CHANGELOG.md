# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [1.2.0] - 2019-01-30

### Exception Hinting

The two exception hints have been moved to the `umber/http` package as they are more relevant there.
Because of this the namespace has changed, please update all references.

* `Umber\Common\Exception\Hint\CanonicalAwareExceptionInterface` is now `Umber\Http\Hint\HttpCanonicalAwareExceptionInterface`
* `Umber\Common\Exception\Hint\HttpAwareExceptionInterface` is now `Umber\Http\Hint\HttpAwareExceptionInterface`

Note that `CanonicalAwareExceptionInterface` is now known as `HttpCanonicalAwareExceptionInterface` also.

## [1.1.0] - 2018-12-20

### Symfony Bundle
- `umber.http.generate` is now named `umber.http.generator`.
- `umber.http.response.composer` registers the new `HttpResponseComposer`.

## [1.0.0] - 2018-12-19

As the first official supported version loads of changes have been made.
The changelog also misses a few of the pre-release versions.
Sorry.

### Migrated
- `Http` component now exists in `umber/http`.
- `Date` component and factories now exist in `umber/date`.
- `Prototype` component now exists in `umber/prototype`.
- `Database` component now exists in `umber/database`.

## [0.1.3] - 2018-07-02

This release has no code changes.

## [0.1.2] - 2018-07-01

### Removed
- Removed dependency on `lcobucci/jwt` as this dependency better belongs in `umber/authentication`.

## [0.1.1] - 2018-07-01

### Added
- Added `UmberCommonBundle` for anyone using `symfony` and wanting services registered for you.
- Added `FormValidationException` for cases when the `FormHandler` detects form errors.
- Added `AbstractFormTypeTestCase` for setting up the custom `FormFactory` and testing forms against it.
- Added a custom `FormFactoryBuilder` for building the below `FormFactory`.
- Added a custom `FormFactory` that helps implement the below `FormDataAccessor`.
- Added a custom `FormDataAccessor` allowing `php 7.0` type hints to be used.
- Added `RequestFormHandler` (as below) for handling `symfony/form` instances using the `Request` or `RequestStack` provided by `symfony/http-foundation`.
- Added `FormHandler` (its a helper) for handling `symfony/form` instances.

## [0.1.0] - 2018-06-08

### Added
- Added `phpunit.xml.dist`.
- Added `.gitattributes` and `.gitignore`.
- Added `CHANGELOG` and `README`.
- Added the common code base.

### Migrated
- Authentication component moved to `umber/authentication`.
