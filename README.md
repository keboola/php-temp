# Temp Library [![Build Status](https://travis-ci.org/keboola/php-temp.svg?branch=master)](https://travis-ci.org/keboola/php-temp) [![Maintainability](https://api.codeclimate.com/v1/badges/1f0a96227c7e6483467d/maintainability)](https://codeclimate.com/github/keboola/php-temp/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/1f0a96227c7e6483467d/test_coverage)](https://codeclimate.com/github/keboola/php-temp/test_coverage)

This library provides an isolated temporary directory for an application. The library has methods
for generating randomly named folders and files.  

## Usage

```php
use Keboola\Temp\Temp;
$temp = new Temp('prefix');
// Creates a file with unique name suffixed by 'suffix'
$tempFile = $temp->createTmpFile('suffix');
echo 'Files are stored in: ' . $temp->getTmpFolder();
$temp->remove();
```

## Migration from version 1.0
The temp folder is no longer deleted automatically in the destructor. It needs to 
be removed explicitly by calling the `remove()` method.
