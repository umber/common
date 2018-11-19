# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

- Nothing.

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
