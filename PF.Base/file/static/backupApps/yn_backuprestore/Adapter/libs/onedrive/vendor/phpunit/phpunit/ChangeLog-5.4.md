# Changes in PHPUnit 5.4

All notable changes of the PHPUnit 5.4 release series are documented in this file using the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [5.4.4] - 2016-06-09

### Fixed

* Blacklisted phpdocumentor/reflection-docblock 3.0.2 due to https://github.com/phpDocumentor/ReflectionDocBlock/pull/77

## [5.4.3] - 2016-06-09

### Changed

* Renamed `phpunit\framework\TestCase` to `PHPUnit\Framework\TestCase`

## [5.4.2] - 2016-06-03

### Fixed

* Reverted the JUnit XML logfile format change to restore backward compatibility

## [5.4.1] - 2016-06-03

### Fixed

* Fixed [#2186](https://github.com/sebastianbergmann/phpunit/issues/2186): `PHPUnit_Framework_TestCase::getMockBuilder()` should be `public`, not `protected` 

## [5.4.0] - 2016-06-03

### Added

* Implemented [#2037](https://github.com/sebastianbergmann/phpunit/issues/2037): Log more information about failures in JSON output
* Implemented [#2152](https://github.com/sebastianbergmann/phpunit/issues/2152): Filter for which tests TestDox output is generated
* Added support for the `ENV`, `STDIN`, `ARGS`, `FILEEOF`, `FILE_EXTERNAL`, `EXPECT_EXTERNAL`, `EXPECTF_EXTERNAL`, `EXPECTREGEX_EXTERNAL`, and `XFAIL` sections to PHPT test runner
* Added TestDox XML logger
* Added `phpunit\framework\TestCase` as an alias for `PHPUnit_Framework_TestCase` for forward compatibility

### Changed

* The `PHPUnit_Framework_TestCase::getMock()` method has been deprecated. Please use `PHPUnit_Framework_TestCase::createMock()` or `PHPUnit_Framework_TestCase::getMockBuilder()` instead.
* The `PHPUnit_Framework_TestCase::getMockWithoutInvokingTheOriginalConstructor()` method has been deprecated. Please use `PHPUnit_Framework_TestCase::createMock()` instead.
* The logfile format generated using the `--log-junit` option and the `<log type="junit" target="..."/>` configuration directive has been updated to match the [current format used by JUnit](http://llg.cubic.org/docs/junit/). Due to this change you may need to update how your continuous integration server processes test select logfiles generated by PHPUnit.
* The usage of test doubles created via data providers has been improved

[5.4.4]: https://github.com/sebastianbergmann/phpunit/compare/5.4.3...5.4.4
[5.4.3]: https://github.com/sebastianbergmann/phpunit/compare/5.4.2...5.4.3
[5.4.2]: https://github.com/sebastianbergmann/phpunit/compare/5.4.1...5.4.2
[5.4.1]: https://github.com/sebastianbergmann/phpunit/compare/5.4.0...5.4.1
[5.4.0]: https://github.com/sebastianbergmann/phpunit/compare/5.3...5.4.0

