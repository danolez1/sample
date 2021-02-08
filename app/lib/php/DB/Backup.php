<?php

namespace danolez\lib\DB;

use danolez\lib\DB\Database;
use danolez\lib\DB\DataType;


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

    protected  function sql()
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

    public function download()
    {
        # code...
    }

    public function backUpToServer()
    {
        # code...
    }

    public function upload()
    {
        # code...
    }

    protected function csv()
    {

        $thequery = "SELECT * FROM members";
        $result = mysqli_query($conn, $thequery);

        $file = fopen("php://output", "w");

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported.' . date("Y.m.d") . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $emptyarr = array();
        $fieldinf = mysqli_fetch_fields($result);
        foreach ($fieldinf as $valu) {
            array_push($emptyarr, $valu->name);
        }
        fputcsv($file, $emptyarr);

        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($file, $row);
        }
        fclose($file);

        mysqli_free_result($result);
        mysqli_close($conn);
        $q = "
    SELECT * FROM mytable INTO OUTFILE 'fullpath/mytable.csv'
    FIELDS TERMINATED BY ','
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\n';
";
        # code...
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('ID', 'First Name', 'Last Name', 'Email', 'Joining Date'));
        $query = "SELECT * from employeeinfo ORDER BY emp_id DESC";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);

        if (isset($_POST["Import"])) {

            $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $sql = "INSERT into employeeinfo (emp_id,firstname,lastname,email,reg_date) 
                           values ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "')";
                    $result = mysqli_query($con, $sql);
                    if (!isset($result)) {
                        echo "<script type=\"text/javascript\">
                      alert(\"Invalid File:Please Upload CSV File.\");
                      window.location = \"index.php\"
                      </script>";
                    } else {
                        echo "<script type=\"text/javascript\">
                    alert(\"CSV File has been successfully Imported.\");
                    window.location = \"index.php\"
                  </script>";
                    }
                }

                fclose($file);
            }
        }
    }

    protected  function json()
    {
        # code...
        //remove &quot;
    }


    public function export($type = DataType::MYSQL)
    {
        # code...
    }

    public function import()
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
