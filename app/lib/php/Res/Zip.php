<?php

namespace danolez\lib\Res\Zip;

use ZipArchive;

class Zip
{
    private $paths = array();
    private $zip;
    private $dir;

    public function __construct()
    {
        $this->zip = new \ZipArchive();
    }

    public function zip($path)
    {
        $status = $this->zip->open($path,  ZipArchive::CREATE);
        if (count($this->paths) > 0) {
            foreach ($this->paths as $fileToAdd) {
                $this->zip->addFile($fileToAdd);
            }
        }
        if ($this->dir != NULL || $this->dir != "") {
            if ($handle = opendir($this->dir)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && !is_dir($this->dir . $entry)) {
                        $this->zip->addFile($this->dir . DIRECTORY_SEPARATOR . $entry);
                    }
                }
                closedir($handle);
            } else echo 'not dir';
        }
        $this->zip->close();
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
