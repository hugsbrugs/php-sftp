# php-sftp

PHP SFTP Utilities

## Dependencies :

[phpseclib](https://github.com/phpseclib/phpseclib) : [Documentation](https://api.phpseclib.org/master/) - [Examples](http://phpseclib.sourceforge.net/sftp/examples.html)

## Install

Install package with composer
```
composer require hugsbrugs/php-sftp
```

In your PHP code, load librairy
```php
require_once __DIR__ . '/vendor/autoload.php';
use Hug\Sftp\Sftp as Sftp;
```

## Usage

Test SFTP connection
```php
Sftp::test($server, $user, $password, $port);
```

Check if a file exists on SFTP Server
```php
Sftp::is_file($server, $user, $password, $remote_file, $port);
```

Delete a file on remote FTP server
```php
Sftp::delete($server, $user, $password, $remote_file, $port);
```

Recursively deletes files and folder in given directory
```php
Sftp::rmdir($server, $user, $password, $remote_path, $port);
```

Recursively copy files and folders on remote SFTP server
```php
Sftp::upload_dir($server, $user, $password, $local_path, $remote_path, $port);
```

Download a file from remote SFTP server
```php
Sftp::download($server, $user, $password, $remote_file, $local_file, $port);
```

Download a directory from remote FTP server
```php
Sftp::download_dir($server, $user, $password, $remote_dir, $local_dir, 
$port);
```

Rename a file on remote SFTP server
```php
Sftp::rename($server, $user, $password, $old_file, $new_file, $port);
```

Create a directory on remote SFTP server
```php
Sftp::mkdir($server, $user, $password, $directory, $port);
```

Create a file on remote SFTP server
```php
Sftp::touch($server, $user, $password, $remote_file, $content, $port);
```

Upload a file on SFTP server
```php
Sftp::upload($server, $user, $password, $local_file, $remote_file = '', $port);
```

List files on SFTP server
```php
Sftp::scandir($server, $user, $password, $path, $port);
```

Get default login SFTP directory aka pwd
```php
Sftp::pwd($server, $user, $password, $port);
```

## To Do

PHPUnit Tests

## Author

Hugo Maugey [visit my website ;)](https://hugo.maugey.fr)