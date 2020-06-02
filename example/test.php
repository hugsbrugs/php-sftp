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
$test = Sftp::scandir($FtpServer, $FtpUser, $FtpPass, $FtpPath, $FtpPort);
echo "scandir";
var_dump($test);

# Test connection
$test = Sftp::test($FtpServer, $FtpUser, $FtpPass, $FtpPort);
echo "test";
var_dump($test);

# Check Login Directory PWD
$test = Sftp::pwd($FtpServer, $FtpUser, $FtpPass, $FtpPort);
echo "pwd";
var_dump($test);



# Upload File
$local_file = __DIR__ . '/test.txt';
$remote_file = $FtpPath . '/test.txt';
$test = Sftp::upload($FtpServer, $FtpUser, $FtpPass, $local_file, $remote_file, $FtpPort);
echo "upload";
var_dump($test);

# Download File
$local_file = __DIR__ . '/test-download.txt';
$remote_file = $FtpPath . '/test.txt';
$test = Sftp::download($FtpServer, $FtpUser, $FtpPass, $remote_file, $local_file, $FtpPort);
echo "download";
var_dump($test);
unlink($local_file);

# Rename File
$old_file = $FtpPath . '/test.txt';
$new_file = $FtpPath . '/test-renamed.txt';
$test = Sftp::rename($FtpServer, $FtpUser, $FtpPass, $old_file, $new_file, $FtpPort);
echo "rename file";
var_dump($test);

# Test file exist
$remote_file = $FtpPath . '/test-renamed.txt';
$test = Sftp::is_file($FtpServer, $FtpUser, $FtpPass, $remote_file, $FtpPort);
echo "is_file";
var_dump($test);

# Delete File
$remote_file = $FtpPath . '/test-renamed.txt';
$test = Sftp::delete($FtpServer, $FtpUser, $FtpPass, $remote_file, $FtpPort);
echo "delete file";
var_dump($test);



# Upload Folder
// if ends with a slash upload content
// if no slash end upload dir itself
$local_path = __DIR__ . '/../src';
$remote_path = $FtpPath;
$test = Sftp::upload_dir($FtpServer, $FtpUser, $FtpPass, $local_path, $remote_path, $FtpPort);
echo "upload_dir";
var_dump($test);

# Download Folder
// if ends with a slash download content
// if no slash end download dir itself
$remote_dir = $FtpPath . '/src';
$local_dir = __DIR__;
$test = Sftp::download_dir($FtpServer, $FtpUser, $FtpPass, $remote_dir, $local_dir, $FtpPort);
var_dump($test);

# Delete Folder
// if ends with a slash delete content
// if no slash delete dir itself
$remote_path = $FtpPath . '/src';
$test = Sftp::rmdir($FtpServer, $FtpUser, $FtpPass, $remote_path, $FtpPort);
var_dump($test);




# Create File
$file_name = $FtpPath . '/test.txt';
$file_content = 'Love it !';
$test = Sftp::touch($FtpServer, $FtpUser, $FtpPass, $file_name, $file_content, $FtpPort);
echo "touch";
var_dump($test);

# Delete File
$remote_file = $FtpPath . '/test.txt';
$test = Sftp::delete($FtpServer, $FtpUser, $FtpPass, $remote_file, $FtpPort);
echo "delete file";
var_dump($test);



# Create Folder
$directory = $FtpPath . '/coucou';
$mode = 0755;
$test = Sftp::mkdir($FtpServer, $FtpUser, $FtpPass, $directory, $FtpPort, $mode);
echo "mkdir";
var_dump($test);


$mode = 0644;
$test = Sftp::chmod($FtpServer, $FtpUser, $FtpPass, $directory, $FtpPort, $mode);
echo "chmod";
var_dump($test);

# Rename Folder
$old_file = $FtpPath . '/coucou';
$new_file = $FtpPath . '/coco';
$test = Sftp::rename($FtpServer, $FtpUser, $FtpPass, $old_file, $new_file, $FtpPort);
echo "rename dir";
var_dump($test);

# Delete Folder
$remote_path = $FtpPath . '/coco';
$test = Sftp::rmdir($FtpServer, $FtpUser, $FtpPass, $remote_path, $FtpPort);
echo "rmdir";
var_dump($test);



# Scan directory again
$test = Sftp::scandir($FtpServer, $FtpUser, $FtpPass, $FtpPath, $FtpPort);
echo "scandir";
var_dump($test);
