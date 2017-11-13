# Keboola PHP Temp service

## Usage

```php
    use Keboola\Temp\Temp;
	$temp = new Temp('prefix');
	// Creates a file with unique name suffixed by 'suffix'
    $tempFile = $temp->createTmpFile('suffix');
```
