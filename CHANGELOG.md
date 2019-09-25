# Changelog
All Notable changes to `flipboxdigital\relay-salesforce` will be documented in this file

## Unreleased
### Added
- Ability to call a resource url directly. Useful when an api response gives it to you (more results, nexted resources, etc).

## 2.0.0 - 2018-04-24
### Changed
- All caching now implements [PSR-16](https://www.php-fig.org/psr/psr-16/)

## 1.0.1 - 2018-04-16
### Added
- [Resources by Version](https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_discoveryresource.htm) middleware and pipeline builder

### Changed
- Fixed incorrect describe global resource endpoint

## 1.0.0 - 2018-04-13
- Initial release
