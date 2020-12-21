<?php

namespace danolez\lib\Res\File;

class File
{
    private $path;
    private $extension;
    private $url;
    private $mimeType;
    private $tempPath;
    private $size;
    private $name;
    private $dir;
    private $realPath;
    private $error;
    private $pathInfo;
    private $initalPath;
    private $permission;
    private $password;
    private $key;
    private $pointer;
    private $exist;
    private $baseContent;
    private $file;
    private $content;
    private $access;

    const DIRECTORY = "dirname";
    const BASENAME = "basename";
    const EXTENSION = "extension";
    const FILENAME = "filename";

    const READ_ONLY = "r";
    const READ_WRITE = "r+";
    const WRITE_ONLY = "w";
    const WRITE_READ = "w+";
    const OPEN_WRITE = "a";
    const OPEN_WRITE_READ = "a+";

    const ERR_OPENING_FILE = "Error in opening file";
    const ERR_NO_FILE = "File does not exist";
    const ERR_REMOVAL_FAILURE = "Could not remove";

    const PREFIX = "AZA01";

    const DEVICE_NUMBER = "dev";
    const INODE_NUMBER = "ino";
    const INODE_MODE = "mode";
    const INODE_DEVICE_TYPE = "rdev";
    const NUMBER_OF_LINK = "nlink";
    const OWNER_USER_ID = "uid";
    const OWNER_GROUP_ID = "gid";
    const SIZE = "size";
    const LAST_ACCESS = "atime";
    const LAST_MODIFIED = "mtime";
    const LAST_INODE_CHANGE = "ctime";
    const BLOCKSIZE = "blksize";
    const NUMBER_OF_BLOVKS = "blocks";

    const CACHE = "cache";
    const POINTER_BEGINNING  = 0;


    /**
     * __construct
     *
     * @param  mixed $path localfile or webpage
     * @return this
     */
    public function __construct(string $path, string $access = self::READ_ONLY)
    {
        $this->setPath($path);
        $this->initalPath = $path;
        $this->setAccess($access);
        $this->read();

        return $this;
    }

    public function read($size = null)
    {
        $this->file = fopen($this->path, $this->access);
        if ($this->file == false) {
            $this->setError(self::ERR_OPENING_FILE);
        } else {
            $this->setPathInfo(pathinfo($this->getPath()));
            $this->setDir($this->getPathInfo()[self::DIRECTORY]);
            $this->setExtension($this->getPathInfo()[self::EXTENSION]);
            $this->setRealPath(realpath($this->path));
            $this->setName($this->getPathInfo()[self::BASENAME]);
            $this->setSize(filesize($this->file));
            if ($size == null) {
                $this->baseContent = fread($this->file, $this->size);
                $this->setContent($this->baseContent);
            } else {
                $this->baseContent = readfile($this->file);
                $this->setContent(fread($this->file, $size));
            }
        }
        return $this;
    }

    public function delete(string $path = null)
    {
        if (is_null($path)) return true;
        $this->close();
        return unlink($path);
    }
    public function isExist()
    {
        if (file_exists($this->getPath())) {
            $this->exist = true;
        } else {
            $this->exist = false;
        }
        return $this->exist;
    }

    public function download()
    {
        //Get the basename of the zip file.
        //$zipBaseName = basename($path);

        //Set the Content-Type, Content-Disposition and Content-Length headers.
        // header("Content-Type: application/zip");
        // header("Content-Disposition: attachment; filename=$zipBaseName");
        // header("Content-Length: " . filesize($zipFilePath));

        //Read the file data and exit the script.
        //readfile($path);
    }



    public function copy()
    {
        # code...
    }

    public function replaceContent()
    {
        # code...
    }

    public function getFileInfo()
    {
        return stat($this->getPath());
    }

    public function write($content = null)
    {
        if (is_null($content())) {
            $content =  $this->getContent();
        }
        fwrite($this->file, $content);
    }

    public static function getTempDirectory()
    {
        return sys_get_temp_dir();
    }

    public static function getCache()
    {
        return array(self::CACHE => realpath_cache_get(), self::SIZE => realpath_cache_size());
    }

    public static function makeDirectory(string $dir)
    {
        return mkdir($dir);
    }
    public static function removeDirectory(string $dir)
    {
        return (rmdir($dir));
    }

    public static function createTempFile(string $path = null)
    {
        if ($path == null) {
            $tmp = tmpfile();
        } else {
            $tmp = tempnam($path, self::PREFIX);
        }
        $file = new File($tmp);
        return $file;
    }

    /**
     * renameFile or Directory
     *
     * @param  mixed $inital
     * @param  mixed $final
     * @return void
     */
    public static function renameFile(string $inital, string $final)
    {
        return rename($inital, $final);
    }

    public function rename(string $name = null)
    {
        if ($name == null) {
            $name = $this->path;
        }
        return rename($this->initalPath, $name);
    }

    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function setPath($path)
    {
        $this->path = $path;
        $this->read();
        return $this;
    }

    /**
     * Get the value of size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of size
     *
     * @return  self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    public function close()
    {
        fclose($this->file);
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of access
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set the value of access
     *
     * @return  self
     */
    public function setAccess($access)
    {
        $this->access = $access;
        $this->read();
        return $this;
    }

    /**
     * Get the value of error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the value of error
     *
     * @return  self
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of pathInfo
     */
    public function getPathInfo()
    {
        return $this->pathInfo;
    }

    /**
     * Set the value of pathInfo
     *
     * @return  self
     */
    public function setPathInfo($pathInfo)
    {
        $this->pathInfo = $pathInfo;

        return $this;
    }

    /**
     * Get the value of dir
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Set the value of dir
     *
     * @return  self
     */
    public function setDir($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * Get the value of extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the value of extension
     *
     * @return  self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get the value of realPath
     */
    public function getRealPath()
    {
        return $this->realPath;
    }

    /**
     * Set the value of realPath
     *
     * @return  self
     */
    public function setRealPath($realPath)
    {
        $this->realPath = $realPath;

        return $this;
    }

    /**
     * Get the value of pointer
     */
    public function getPointer()
    {
        return $this->pointer;
    }

    /**
     * Set the value of pointer
     *
     * @return  self
     */
    public function setPointer($pointer)
    {
        $this->pointer = "$pointer";
        if ($pointer = 0)
            rewind($this->file);
        else
            fseek($this->file, $pointer);
        return $this;
    }
}
