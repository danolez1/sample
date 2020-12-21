<?php

namespace danolez\lib\DB\Database;

use danolez\lib\DB\Database\Database;

class DBBackup
{

    //     $backup = new DBBackup($db);
    // $backup->download();
    private $db;
    private $tables = [];
    private $sql;

    const CHARSET = 'utf-8';

    public function __construct(Database $db)
    {
        $this->setDb($db);
        $this->db->DB()->set_charset(self::CHARSET);
    }

    protected function getTables()
    {
        $sql = "SHOW TABLES";
        $result = mysqli_query($this->db->DB(), $sql);
        while ($row = mysqli_fetch_row($result)) {
            $this->tables[] = $row[0];
        }
    }

    protected function getTableColumns()
    {
        $this->sql = "";
        foreach ($this->tables as $table) {
            // Prepare SQLscript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($this->db->DB(), $query);
            $row = mysqli_fetch_row($result);

            $this->sql .= "\n\n" . $row[1] . ";\n\n";


            $query = "SELECT * FROM $table";
            $result = mysqli_query($this->db->DB(), $query);

            $columnCount = mysqli_num_fields($result);

            // Prepare SQLscript for dumping data for each table
            for ($i = 0; $i < $columnCount; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $this->sql .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j++) {
                        $row[$j] = $row[$j];

                        if (isset($row[$j])) {
                            $this->sql .= '"' . $row[$j] . '"';
                        } else {
                            $this->sql .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $this->sql .= ',';
                        }
                    }
                    $this->sql .= ");\n";
                }
            }

            $this->sql .= "\n";
        }
    }

    public function sql()
    {
        $this->getTables();
        $this->getTableColumns();
        if (!empty($this->sql)) {
            // Save the SQL script to a backup file
            $backup_file_name = $this->db->getName() . '_backup_' . time() . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $this->sql);
            fclose($fileHandler);

            // Download the SQL backup file to the browser
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backup_file_name));
            ob_clean();
            flush();
            readfile($backup_file_name);
            exec('rm ' . $backup_file_name);
        }
    }

    public function csv()
    {
        # code...
    }

    public function json()
    {
        # code...
    }

    /**
     * Get the value of db
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Set the value of db
     *
     * @return  self
     */
    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }

    /**
     * Get the value of sql
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * Set the value of sql
     *
     * @return  self
     */
    public function setSql($sql)
    {
        $this->sql = $sql;

        return $this;
    }
}
