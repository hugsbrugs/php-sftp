<?php

# For PHP7
// declare(strict_types=1);

// namespace Hug\Tests\Sftp;

use PHPUnit\Framework\TestCase;

use Hug\Sftp\Sftp as Sftp;

/**
 *
 */
final class SftpTest extends TestCase
{    

    /* ************************************************* */
    /* ******************* Sftp::test ****************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanTest()
    {
        $test = Sftp::test($server, $user, $password, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ****************** Sftp::is_file **************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanIsFile()
    {
        $test = Sftp::is_file($server, $user, $password, $remote_file, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ****************** Sftp::delete ***************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanDelete()
    {
        $test = Sftp::delete($server, $user, $password, $remote_file, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ****************** Sftp::rmdir ****************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanRmdir()
    {
        $test = Sftp::rmdir($server, $user, $password, $remote_path, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* **************** Sftp::upload_dir *************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanUploadDir()
    {
        $test = Sftp::upload_dir($server, $user, $password, $local_path, $remote_path, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ***************** Sftp::download **************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanDownload()
    {
        $test = Sftp::download($server, $user, $password, $remote_file, $local_file, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* *************** Sftp::download_dir ************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanDownloadDir()
    {
        $test = Sftp::download_dir($server, $user, $password, $remote_dir, $local_dir, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ****************** Sftp::rename ***************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanRename()
    {
        $test = Sftp::rename($server, $user, $password, $old_file, $new_file, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ******************* Sftp::mkdir ***************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanMkdir()
    {
        $test = Sftp::mkdir($server, $user, $password, $directory, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ******************* Sftp::touch ***************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanTouch()
    {
        $test = Sftp::touch($server, $user, $password, $remote_file, $content, $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ****************** Sftp::upload ***************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanUpload()
    {
        $test = Sftp::upload($server, $user, $password, $local_file, $remote_file = '', $port);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ****************** Sftp::scandir **************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanScandir()
    {
        $test = Sftp::scandir($server, $user, $password, $path, $port);
        $this->assertTrue($test);
    }


    /* ************************************************* */
    /* ******************** Sftp::pwd ****************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanPwd()
    {
        $test = Sftp::pwd($server, $user, $password, $port);
        $this->assertTrue($test);
    }

}
