<?php

namespace danolez\lib\DB;

use danolez\lib\DB\Credential;
use danolez\lib\Security\Encoding;

class File
{

    private $size;
    private $dateCreated;
    private $lastModified;
    private $path;
    private $fileName;
    private $file;

    const DIRECTORY_SEPERATOR = '/';
    const ITERATION = 1;

    public function __construct($filePath, $encode = true)
    {
        $file = file_exists($filePath);
        if (!$file) {
            $file = file_put_contents($filePath, '');
        }
        $this->setPath($filePath);
        $temp = explode(self::DIRECTORY_SEPERATOR, $filePath);
        $this->setFileName($temp[count($temp) - 1]);
        $this->setFile(json_decode($encode ? Credential::decrypt(Encoding::decode(file_get_contents($filePath), self::ITERATION)) : file_get_contents($filePath)));
        $this->setSize(strlen(json_encode($this->getFile())));
        $this->setDateCreated(filectime($this->getPath()));
        $this->setLastModified(filemtime($this->getPath()));
    }

    public function save($encode = true)
    {
        if (!$encode) {
            file_put_contents($this->getPath(), $this->getFile());
        } else
            return file_put_contents($this->getPath(), Encoding::encode(Credential::encrypt($this->getFile()), self::ITERATION));
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

    /**
     * Get the value of file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
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

        return $this;
    }

    /**
     * Get the value of lastModified
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set the value of lastModified
     *
     * @return  self
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get the value of fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @return  self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of dateCreated
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set the value of dateCreated
     *
     * @return  self
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
