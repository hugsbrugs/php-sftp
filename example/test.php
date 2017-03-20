<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('max_execution_time', 0);

require_once __DIR__ . '/../vendor/autoload.php';

use Hug\Sftp\Sftp as Sftp;

$FtpServer = 'sftp.your.host.com';
$FtpPort = 22;
$FtpUser = 'username';
$FtpPass = 'password';
$FtpPath = '/home/web/public_html';

# Scan Directory
// $test = Sftp::scandir($FtpServer, $FtpUser, $FtpPass, $FtpPath, $FtpPort);
// echo "Test FTP Connection with correct parameters<br>";
// var_dump($test);

// $test = Sftp::test($FtpServer, $FtpUser, $FtpPass, $FtpPort);
// echo "Test FTP Connection with correct parameters<br>";
// var_dump($test);

# Check Login Directory PWD
// $test = Sftp::pwd($FtpServer, $FtpUser, $FtpPass, $FtpPort);
// echo "Test FTP Connection with correct parameters<br>";
// var_dump($test);

# Upload File
// $local_file = __DIR__ . '/test.txt';
// $remote_file = $FtpPath . '/test.txt';
// $test = Sftp::upload($FtpServer, $FtpUser, $FtpPass, $local_file, $remote_file, $FtpPort);
// var_dump($test);

# Download File
// $local_file = __DIR__ . '/test1.txt';
// $remote_file = $FtpPath . '/test.txt';
// $test = Sftp::download($FtpServer, $FtpUser, $FtpPass, $remote_file, $local_file, $FtpPort);
// var_dump($test);

# Delete File
// $remote_file = $FtpPath . '/test.txt';
// $test = Sftp::delete($FtpServer, $FtpUser, $FtpPass, $remote_file, $FtpPort);
// var_dump($test);

# Rename File
// $old_file = $FtpPath . '/test.txt';
// $new_file = $FtpPath . '/test-new.txt';
// $test = Sftp::rename($FtpServer, $FtpUser, $FtpPass, $old_file, $new_file, $FtpPort);
// var_dump($test);

# Test file exist
// $remote_file = $FtpPath . '/test-new.txt';
// $test = Sftp::is_file($FtpServer, $FtpUser, $FtpPass, $remote_file, $FtpPort);
// var_dump($test);


# Upload Folder
// $local_path = __DIR__ . '/../src/';
// $remote_path = $FtpPath;// . '/' No trailing slash
// $test = Sftp::upload_dir($FtpServer, $FtpUser, $FtpPass, $local_path, $remote_path, $FtpPort);
// var_dump($test);

# Download Folder
// $remote_dir = $FtpPath . '/Hug';
// $local_dir = '/home/hugo/download';
// $test = Sftp::download_dir($FtpServer, $FtpUser, $FtpPass, $remote_dir, $local_dir, $FtpPort);
// var_dump($test);

# Delete Folder
// $remote_path = $FtpPath . '/Hug';
// $test = Sftp::rmdir($FtpServer, $FtpUser, $FtpPass, $remote_path, $FtpPort);
// var_dump($test);


# Create File
// $file_name = $FtpPath . '/coucou/test.txt';
// $file_content = 'Love it !';
// $test = Sftp::touch($FtpServer, $FtpUser, $FtpPass, $file_name, $file_content, $FtpPort);
// var_dump($test);

# Create Folder
// $directory = $FtpPath . '/coucou';
// $test = Sftp::mkdir($FtpServer, $FtpUser, $FtpPass, $directory, $FtpPort);
// var_dump($test);

# Rename Folder
// $old_file = $FtpPath . '/coucou';
// $new_file = $FtpPath . '/caca';
// $test = Sftp::rename($FtpServer, $FtpUser, $FtpPass, $old_file, $new_file, $FtpPort);
// var_dump($test);

# Scan directory again
// $test = Sftp::scandir($FtpServer, $FtpUser, $FtpPass, $FtpPath, $FtpPort);
// echo "Test FTP Connection with correct parameters<br>";
// var_dump($test);
