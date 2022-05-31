# Temp Library [![Build Status](https://travis-ci.org/keboola/php-temp.svg?branch=master)](https://travis-ci.org/keboola/php-temp) [![Maintainability](https://api.codeclimate.com/v1/badges/1f0a96227c7e6483467d/maintainability)](https://codeclimate.com/github/keboola/php-temp/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/1f0a96227c7e6483467d/test_coverage)](https://codeclimate.com/github/keboola/php-temp/test_coverage)

This library provides an isolated temporary folder for an application. The library has methods
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

Available methods:

- `getTmpFolder` -- Get the name of the temporary folder.
- `createFile` -- Create a named file in the temporary folder.
- `createTmpFile` -- Create a random file in the temporary folder.

## Migration from version 1.0
- The temp folder is no longer deleted automatically in the destructor. It needs to 
  be removed explicitly by calling the `remove()` method.
- The public `setId` method was removed. This function was rarely used and is no longer available.
- The public `initRunFolder` method was removed. The folder is now initialized when used and there is 
no need to call `initRunFolder` any more.
- The protected `getTmpPath` method is now private. 

## License

MIT licensed, see [LICENSE](./LICENSE) file.
