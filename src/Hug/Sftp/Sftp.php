<?php

namespace Hug\Sftp;

use phpseclib\Net\SFTP as SecFtp;

class Sftp
{

	/**
     * Login to SFTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param int $port
     *
     * @return resource $sftp
     *
     */
    private static function login($server, $user, $password, $port = 22)
    {
        $sftp = null;
        try
        {
        	$sftp = new SecFtp($server, $port);
			if(!$sftp->login($user, $password))
			{
				$sftp = false;
	        }
        }
        catch(Exception $e)
        {
            error_log("SFtp::login : " . $e->getMessage());
        }
        return $sftp;
    }

    /**
     * Test SFTP connection
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     *
     * @return bool $test
     *
     */
    public static function test($server, $user, $password, $port = 22)
    {
        $test = false;
        try
        {
        	if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
                $test = true;
            }
        }
        catch(Exception $e)
        {
            error_log("Sftp::test : " . $e->getMessage());
        }
        return $test;
    }

    /**
	 * Check if a file exists on SFTP Server
	 * 
	 * @param string $server 
	 * @param string $user
	 * @param string $password
	 * @param string $remote_file
	 * @param int $port
	 *
	 * @return bool $is_file
	 */
	public static function is_file($server, $user, $password, $remote_file, $port = 22)
	{
	    $is_file = false;
	    try
	    {
			if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
				if($sftp->is_file($remote_file))
				{
	                $is_file = true;
				}
	        }
	    }
	    catch(Exception $e)
	    {
	        error_log("Sftp::is_file : " . $e->getMessage());
	    }

	    return $is_file;
	}

    /**
     * Deletes a file on remote FTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $remote_file
     * @param int $port
     *
     * @return bool $deleted
     *
     */
    public static function delete($server, $user, $password, $remote_file, $port = 22)
    {
        $deleted = false;

        try
        {
            if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
                if($sftp->is_file($remote_file))
                {
                    if($sftp->delete($remote_file))
                    {
                        $deleted = true;
                    }
                }
            }
        }
        catch(Exception $e)
        {
            error_log("Sftp delete : " . $e->getMessage());
        }

        return $deleted;
    }

    /**
     * Recursively deletes files and folder in given directory
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $remote_path
     * @param int $port
     *
     * @return bool $deleted
     *
     */
    public static function rmdir($server, $user, $password, $remote_path, $port = 22)
    {
        $deleted = false;
        try
        {
            if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
                # Delete
                if(Sftp::clean_dir($remote_path, $sftp))
                {
                    if($sftp->rmdir($remote_path))
                    {
                        $deleted = true;
                    }
                }
            }
        }
        catch(Exception $e)
        {
            error_log("Ftp rmdir : " . $e->getMessage());
        }
        return $deleted;
    }

    /**
     * Recursively deletes files and folder
     *
     * @param string $remote_path
     * @param resource $sftp
     *
     * @return bool $clean
     */
    private static function clean_dir($remote_path, $sftp)
    {
        $clean = false;

        $list = $sftp->nlist($remote_path);
        $to_delete = 0;
        $deleted = 0;
        foreach ($list as $element)
        {
            if($element!=='.' && $element!=='..')
            {
                $to_delete++;
                // error_log('element : ' . $element);
                
                if($sftp->is_dir($remote_path . DIRECTORY_SEPARATOR . $element))
                {
                    # Empty directory
                    Sftp::clean_dir($remote_path . DIRECTORY_SEPARATOR . $element, $sftp);

                    # Delete empty directory
                    if($sftp->rmdir($remote_path . DIRECTORY_SEPARATOR . $element)) 
                    {
                        $deleted++;
                    }
                }
                else
                {
                    # Delete file
                    if($sftp->delete($remote_path . DIRECTORY_SEPARATOR . $element))
                    {
                        $deleted++;
                    }
                }
            }
        }
        if($deleted===$to_delete)
        {
            $clean = true;   
        }
        return $clean;
    }

	/**
	 * Recursively copy files and folders on remote SFTP server
	 *
	 * @param string $server 
	 * @param string $user
	 * @param string $password
	 * @param string $local_path
	 * @param string $remote_path
	 * @param int $port
	 *
	 * @return bool $uploaded
	 *
	 */
	public static function upload_dir($server, $user, $password, $local_path, $remote_path, $port = 22)
	{
	    $uploaded = false;
	    try
	    {
	    	# Remove trailing slash
	 		$remote_path = rtrim($remote_path, DIRECTORY_SEPARATOR);   	
	    	
	    	if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
				if($sftp->is_dir($remote_path))
				{
		            $copy_result = Sftp::upload_all($sftp, $local_path, $remote_path); 
		            $uploaded = true;
				}
	        }
	    }
	    catch(Exception $e)
	    {
	        error_log("Problème SFTP : " . $e->getMessage());
	    }
	    return $uploaded;
	}

	/**
	 * Recursively copy files and folders on remote SFTP server
	 *
	 * @param SFTP $sftp
	 * @param string $local_dir
	 * @param string $remote_dir
	 *
	 * @return bool $copy
	 *
	 */
	private static function upload_all($sftp, $local_dir, $remote_dir)
	{
	    try
	    {
	    	// error_log('sftp_copy_all ' . $local_dir . ' -> ' . $remote_dir);
	        if(!$sftp->is_dir($remote_dir))
	        {
	            if(!$sftp->mkdir($remote_dir))
	            {
	            	error_log("Cannot create directory " . $remote_dir);
	            	return false;
	            }
	            // error_log("upload_all : ".$remote_dir." Already exists.");
	        }

	        $d = dir($local_dir);
	        while($file = $d->read())
	        {
	            if ($file != "." && $file != "..")
	            {
	                if(is_dir($local_dir . DIRECTORY_SEPARATOR . $file))
	                {
	                	# recursive part
	                	// error_log('DIR : ' . $local_dir . DIRECTORY_SEPARATOR . $file  .' -> ' . $remote_dir . DIRECTORY_SEPARATOR . $file);
	                    Sftp::upload_all(
	                    	$sftp, 
	                    	$local_dir . DIRECTORY_SEPARATOR . $file, 
	                    	$remote_dir . DIRECTORY_SEPARATOR . $file);
	                }
	                else
	                { 
	                	error_log('FILE : ' . $local_dir . DIRECTORY_SEPARATOR . $file  .' -> ' . $remote_dir . DIRECTORY_SEPARATOR . $file);
	                    $put = $sftp->put(
	                    	$remote_dir . DIRECTORY_SEPARATOR . $file,
	                    	$local_dir . DIRECTORY_SEPARATOR . $file,
	                    	SecFtp::SOURCE_LOCAL_FILE);
	                    error_log('put : ' . $put);
	                } 
	            }
	        }
	        $d->close(); 
	    }
	    catch(Exception $e)
	    {
	        error_log("Sftp::upload_all : ".$e);
	    }
	    return true;
	}

	/**
     * Downloads a file from remote SFTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $remote_file
     * @param string $local_file
     * @param int $port
     *
     * @return bool $downloaded
     *
     */
    public static function download($server, $user, $password, $remote_file, $local_file, $port = 22)
    {
        $downloaded = false;
        try
        {
        	if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
                # Download File
                if($sftp->get($remote_file, $local_file))
                {
                    $downloaded = true;
                }
            }
        }
        catch(Exception $e)
        {
            error_log("Sftp download : " . $e->getMessage());
        }
        return $downloaded;
    }

    /**
     * Downloads a directory from remote FTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $remote_dir
     * @param string $local_dir
     * @param int $port
     *
     * @return bool $downloaded
     *
     */
    public static function download_dir($server, $user, $password, $remote_dir, $local_dir, $port = 22)
    {
        $downloaded = false;
        try
        {
            if(is_dir($local_dir) && is_writable($local_dir))
            {
                if(false !== $sftp = Sftp::login($server, $user, $password, $port))
				{
					# Create fisrt level directory on local filesystem
					$local_dir = rtrim($local_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename($remote_dir);
					if(mkdir($local_dir))
					{
	                    $downloaded = Sftp::download_all($sftp, $remote_dir, $local_dir);
					}
                }
            }
            else
            {
                throw new Exception("Local directory does not exist or is not writable", 1);
            }
        }
        catch(Exception $e)
        {
            error_log("Ftp download_dir : " . $e->getMessage());
        }
        return $downloaded;
    }

    /**
     *
     *
     * @param ressource $sftp
     * @param string $remote_dir
     * @param string $local_dir
     *
     * @return bool true
     *
     */
    private static function download_all($sftp, $remote_dir, $local_dir)
    {
    	$download_all = false;
        try
        {
            if($sftp->is_dir($remote_dir))
            {
                $files = $sftp->nlist($remote_dir);
                if($files!==false)
                {
                	$to_download = 0;
                	$downloaded = 0;
                    # do this for each file in the remote directory 
                    foreach ($files as $file)
                    {
                    	// error_log('file : ' . $file);
                        # To prevent an infinite loop 
                        if ($file != "." && $file != "..")
                        {
                        	$to_download++;
                            # do the following if it is a directory 
                            if ($sftp->is_dir($remote_dir . DIRECTORY_SEPARATOR . $file))
                            {                                
                                # Create directory on local filesystem
                                mkdir($local_dir . DIRECTORY_SEPARATOR . basename($file));
                                
                                # Recursive part 
                                if(Sftp::download_all($sftp, $remote_dir . DIRECTORY_SEPARATOR .$file, $local_dir . DIRECTORY_SEPARATOR . basename($file)))
                                {
                                	$downloaded++;
                                }
                            }
                            else
                            { 
                                # Download files 
                                if($sftp->get($remote_dir . DIRECTORY_SEPARATOR . $file, $local_dir . DIRECTORY_SEPARATOR . basename($file)))
                                {
                                	$downloaded++;
                                }
                            } 
                        }
                    }

                    # Check all files and folders have been downloaded
                    if($to_download===$downloaded)
                    {
                    	$download_all = true;
                    }
                }
                else
                {
                	# Nothing to download
                	$download_all = true;
                }
            }
        }
        catch(Exception $e)
        {
            error_log("Ftp download_all : " . $e->getMessage());
        }
        return $download_all;
    }

	/**
     * Renames a file on remote SFTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $old_file
     * @param string $new_file
     * @param int $port
     *
     * @return bool $renamed
     *
     */
	public static function rename($server, $user, $password, $old_file, $new_file, $port = 22)
	{
	    $renamed = false;

	    try
	    {
	    	if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
				if($sftp->rename($old_file, $new_file))
				{
	                $renamed = true;
				}
	        }
	    }
	    catch(Exception $e)
	    {
	        error_log("Sftp::rename : " . $e->getMessage());
	    }

	    return $renamed;
	}

	/**
     * Creates a directory on remote SFTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $directory
     * @param int $port
     *
     * @return bool $created
     *
     */
	public static function mkdir($server, $user, $password, $directory, $port = 22)
	{
	    $created = false;

	    try
	    {
	    	if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
				if($sftp->mkdir($directory, true))
				{
	                $created = true;
				}
	        }
	    }
	    catch(Exception $e)
	    {
	        error_log("Sftp::mkdir : " . $e->getMessage());
	    }

	    return $created;
	}

	/**
     * Creates a file on remote SFTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $remote_file
     * @param int $port
     *
     * @return bool $content
     *
     */
    public static function touch($server, $user, $password, $remote_file, $content, $port = 22)
    {
        $created = false;
        try
        {
            if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
                # Create temp file
                $local_file = tmpfile();
                fwrite($local_file, $content);
                fseek($local_file, 0);
                if($sftp->put($remote_file, $local_file,  SecFtp::SOURCE_LOCAL_FILE))
                {
                    $created = true;
                }
                fclose($local_file);
            } 
        }
        catch(Exception $e)
        {
            error_log("Sftp::touch : " . $e->getMessage());
        }
        return $created;
    }

	/**
	 * Uploads a file on SFTP server
	 *
	 * @param string $server 
	 * @param string $user
	 * @param string $password
	 * @param string $local_file
	 * @param string $remote_file
	 * @param int $port
	 *
	 * @return array $uploaded Result : status (error|success) & message (explains error's origin : most probably access problem)
	 *
	 */
	public static function upload($server, $user, $password, $local_file, $remote_file = '', $port = 22)
	{
	    $uploaded = false;
	    
	    try
	    {
	    	# SET ROOT PATH AND SAME FILE NAME
		    if($remote_file==='')
		    {
		        $remote_file = basename($local_file);
		    }

	    	if(false !== $sftp = Sftp::login($server, $user, $password, $port))
			{
				// error_log('Login SFTP pwd : ' . $sftp->pwd());
				if($sftp->put($remote_file, $local_file, SecFtp::SOURCE_LOCAL_FILE))
				{
	                $uploaded = true;
				}
	        }
	    }
	    catch(Exception $e)
	    {
	        error_log("Problème FTP : ".$e);
	    }
	    return $uploaded;
	}

	/**
     * List files on SFTP server
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param string $path
     * @param int $port
     *
     * @return array $uploaded Result : status (error|success) & message (explains error's origin : most probably access problem)
     *
     */
    public static function scandir($server, $user, $password, $path, $port = 22)
    {
        $files = false;

        if(false !== $sftp = Sftp::login($server, $user, $password, $port))
		{
            $files = $sftp->nlist($path);
        }
        if(is_array($files))
        {
        	# Removes . and ..
        	$files = array_diff($files, ['.', '..']);
        }

        return $files;
    }

    /**
     * Get default login SFTP directory aka pwd
     *
     * @param string $server 
     * @param string $user
     * @param string $password
     * @param int $port
     *
     * @return array $uploaded Result : status (error|success) & message (explains error's origin : most probably access problem)
     *
     */
    public static function pwd($server, $user, $password, $port = 22)
    {
        $dir = false;

        if(false !== $sftp = Sftp::login($server, $user, $password, $port))
		{
            $dir = $sftp->pwd();
        } 

        return $dir;
    }

}