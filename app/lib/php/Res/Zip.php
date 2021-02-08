<?php

namespace danolez\lib\Res;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class Zip
{
    private $paths = array();
    private $zip;
    private $dir;



    public function __construct()
    {
        $this->zip = new ZipArchive();
    }

    public function error($error)
    {
        return [
            ZipArchive::ER_EXISTS => 'File already exists.',
            ZipArchive::ER_INCONS => 'Zip archive inconsistent.',
            ZipArchive::ER_INVAL => 'Invalid argument.',
            ZipArchive::ER_MEMORY => 'Malloc failure.',
            ZipArchive::ER_NOENT => 'No such file.',
            ZipArchive::ER_NOZIP => 'Not a zip archive.',
            ZipArchive::ER_OPEN => "Can't open file.",
            ZipArchive::ER_READ => 'Read error.',
            ZipArchive::ER_SEEK => 'Seek error.',
        ][$error];
    }

    public function zip($name)
    {
        $status = $this->zip->open($name,  ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
        if ($status == true) {
            if (!empty($this->paths)) {
                foreach ($this->paths as $fileToAdd) {
                    $this->zip->addFile($fileToAdd);
                }
            }
            if (!isEmpty($this->dir)) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($this->dir),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );
                foreach ($files as $name => $file) {
                    if (!str_contains($name, '.git')) {
                        // Skip directories (they would be added automatically)
                        if (!$file->isDir()) {
                            // Get real and relative path for current file
                            $filePath = $file->getRealPath();
                            $relativePath = substr($filePath, strlen($this->dir) + 1);

                            // Add current file to archive
                            $this->zip->addFile($filePath, $relativePath);
                        }
                    }
                }
                $this->zip->close();
            } else echo 'not dir';
        } else
            return $status;
    }

    public function addFiles(...$paths)
    {
        $this->paths = $paths;
    }

    public function addDirectory($dir)
    {
        $this->dir = $dir;
    }

    public function unzip()
    {
        foreach ($this->paths as $file) {
            $this->unzipfile($file);
        }
    }

    private function unzipfile($file)
    {
        $zip = zip_open(realpath(".") . "/" . $file);
        if (!$zip) {
            return ("Unable to proccess file '{$file}'");
        }

        $e = '';

        while ($zip_entry = zip_read($zip)) {
            $zdir = dirname(zip_entry_name($zip_entry));
            $zname = zip_entry_name($zip_entry);

            if (!zip_entry_open($zip, $zip_entry, "r")) {
                $e .= "Unable to proccess file '{$zname}'";
                continue;
            }
            if (!is_dir($zdir)) $this->mkdirr($zdir, 0777);

            #print "{$zdir} | {$zname} \n";

            $zip_fs = zip_entry_filesize($zip_entry);
            if (empty($zip_fs)) continue;

            $zz = zip_entry_read($zip_entry, $zip_fs);

            $z = fopen($zname, "w");
            fwrite($z, $zz);
            fclose($z);
            zip_entry_close($zip_entry);
        }
        zip_close($zip);

        return ($e);
    }

    private function mkdirr($pn, $mode = null)
    {

        if (is_dir($pn) || empty($pn)) return true;
        $pn = str_replace(array('/', ''), DIRECTORY_SEPARATOR, $pn);

        if (is_file($pn)) {
            trigger_error('mkdirr() File exists', E_USER_WARNING);
            return false;
        }

        $next_pathname = substr($pn, 0, strrpos($pn, DIRECTORY_SEPARATOR));
        if ($this->mkdirr($next_pathname, $mode)) {
            if (!file_exists($pn)) {
                return mkdir($pn, $mode);
            }
        }
        return false;
    }
}
