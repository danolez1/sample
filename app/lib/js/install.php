<?php

function zip($dir, $name, $windows = true)
{
    $zip = new ZipArchive();
    $status =  $zip->open($name,  ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
    if ($status == true) {
        if (!empty($dir)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($files as $name => $file) {
                if (!strpos($name, '.git') && !strpos($name, '.vscode')) {
                    // Skip directories (they would be added automatically)
                    if (!$file->isDir()) {
                        // Get real and relative path for current file
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($dir) + 1);
                        if (!$windows) {
                            //  $filePath = str_replace("\\","/",$filePath);   
                            $relativePath = str_replace("\\", "/", $relativePath);
                        }
                        // var_dump(($filePath), $relativePath);
                        // Add current file to archive
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }
            $zip->close();
        } else echo 'not dir';
    } else
        return $status;
}

function replace($find, $put, $file)
{
    $autoload = file_get_contents($file);
    $nf = str_replace($find, $put, $autoload);
    $nf = str_replace($find, $put, $autoload);
    return file_put_contents($file, $nf);
}

function delete_directory($dirname)
{
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while ($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname . "/" . $file))
                unlink($dirname . "/" . $file);
            else
                delete_directory($dirname . '/' . $file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

function deleteAll()
{
    $folder_path = __DIR__;
    $files = glob($folder_path . '/*');

    foreach ($files as $file) {
        if (is_file($file))
            unlink($file);
    }
}




// GET FILE
$file = 'demae-system.zip';
$dir = realpath('C:\xampp\htdocs\demae-sample');
zip($dir, $file, false);

$PATH = basename(__DIR__ . DIRECTORY_SEPARATOR);

$progress = [];
$error = null;
if (isset($_POST['install'])) {
    $zip = new ZipArchive;
    //include Credential,function
    //
    //
    if (is_file($file)) {
        $res = $zip->open($file);
        if ($res === TRUE) {
            $zip->extractTo('.');
            $zip->close();
            $progress[] = "$file extracted";
            unlink($file);
            $progress[] = "$file deleted";
        } else {
            $error = ' unzip failed; ';
        }
    }
    $host = $_POST['host'];
    $dbName = $_POST['dbname'];
    $username = $_POST['dbuname'];
    $pass = $_POST['dbpass'];
    $stripe = $_POST['stripeapi'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    $progress[] = "Input validated";
    require 'autoloader.php';
    $progress[] = "Getting required files";

    $host =  danolez\lib\DB\Credential::encrypt($host);
    $username =  danolez\lib\DB\Credential::encrypt($username);
    $pass =  danolez\lib\DB\Credential::encrypt($pass);

    $progress[] = "Preparing details";
    $progress[] = "Updating new details";

    $SERVER_NAME = "T0daak9ERTFOekZsTkRBME56Y3dOVGRsT1daaFlqSmhOR0ZqTVRBNE9XUTRaRFU0T0RNM1ptRTFPRFU1TnpZejQ4ZWZiZmJkZWZiZmJkZWZiZmJkMzU0Y2VmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZDA1MDZlZmJmYmQyMDQ2Mzk3NGVmYmZiZGVmYmZiZGVmYmZiZDEzMmFlZmJmYmRlZmJmYmQyZWVmYmZiZDNmM2UyMDFkZDY4MGVmYmZiZDU2MTRlZmJmYmRkOGIwZWZiZmJkYzk4OTJjNWQzNmVmYmZiZDZiZWZiZmJkM2UyMGVmYmZiZGVmYmZiZDUyM2I0MTdjZWZiZmJkNTQxZDU1ZWZiZmJkMjhaR0ZpTWpobVpqQmxNMlZoWWpFek16Um1ZekprWldFNU1ETmxZVFU0WTJSbU0yWmtPV1pqWkdZelltUXhZemt4TkRVMllURXdNRFppTnpReU9HWmpNUT09"; //"{{SERVER_NAME}}"
    $SERVER_USERNAME = "WTJJMk1ESTFPRGt6TjJNNE4yUXdPV1ZqTm1JMFpXUTNZbU5oTnpSa1ltSTVPRGczWWpjM05qa3hNelJtWXpFejBiNjM3OGVmYmZiZDBlNTJlZmJmYmRlZmJmYmQ0ZGVmYmZiZDU5NTRlZmJmYmRlZmJmYmRjYWIzZWZiZmJkMTZlZmJmYmRlZmJmYmQzMTJiNTkzN2VmYmZiZDVmMDYyNGVmYmZiZGVmYmZiZGVmYmZiZDA0NmVlZmJmYmQ3M2VmYmZiZDY0NDZlZmJmYmQzNTRhZWZiZmJkZWZiZmJkMzJjZDkyZWZiZmJkNTBlZmJmYmRlZmJmYmQwNzNmM2RlZmJmYmRlZmJmYmRlZmJmYmRjM2FhNTRlZmJmYmRlZmJmYmQ3OWVmYmZiZE1qUXhOV014T0RRNE56SXhPRFU1Tmpjd01qUXlNMlF6WlRjMFlUY3paRGRtT1dKa1kyRmxZbU16TW1OaE56VTJNR1JoTldFd1pUSTVNRFppWlRJNFlnPT0"; //{{SERVER_USERNAME}}
    $SERVER_PASSWORD = "T0dSaE5XRXpNamRsTWpJd1lUZzJZV1kzTkRjM1ltTmxOVGN4Tm1NNU4yRTNPVGM1TlRJM1pqRmxaVGcyWmpsazQ4ZWZiZmJkZWZiZmJkZWZiZmJkMzU0Y2VmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZDA1MDZlZmJmYmQyMDQ2Mzk3NGVmYmZiZGVmYmZiZGVmYmZiZDEzMmFlZmJmYmRlZmJmYmQyZWVmYmZiZDNmM2UyMDFkZDY4MGVmYmZiZDU2MTRlZmJmYmRkOGIwZWZiZmJkYzk4OTJjNWQzNmVmYmZiZDZiZWZiZmJkM2UyMGVmYmZiZGVmYmZiZDUyM2I0MTdjZWZiZmJkNTQxZDU1ZWZiZmJkMjhORE5sTW1KbU5qRTRaR014WldabVltWTFaV1JpTldRM1pHTTBZMkpsTmpSalpqQXdaRGM1T0RFeU1qbGlNalpsT0RBek5HTmxNekZpTkdVd1pEZ3dZZz09"; //{{SERVER_PASSWORD}}
    $DB_NAME = "demae_shop_db"; //"{{DB_NAME}}"
    $SECRET_KEY = "sk_test_51I3efdBTDlmC6SL422IENFLTqwo83qewTPurf6kB8u07Aqr10xoac6Ww10sgh8TgkFN13kl2QI5xNeu0iGok8trN00iGPPDXbr"; //"{{SECRET_KEY}}"
    $DEFAULT_FROM = "Demae System"; //"{{DEFAULT_FROM}}"
    $DEFAULT_FROM_EMAIL =  "admin@demae-system.com"; //"{{DEFAULT_FROM_EMAIL}}"

    replace($SERVER_NAME, $host, DB_CORE . 'Credential.php');
    replace("$SERVER_USERNAME", $username, DB_CORE . 'Credential.php');
    replace($SERVER_PASSWORD, $pass, DB_CORE . 'Credential.php');
    replace($DB_NAME, $dbName, DB_CORE . 'Credential.php');
    if (!empty($stripe))
        replace($SECRET_KEY, $stripe, RESOURCES . 'StripeApi.php');
    replace($DEFAULT_FROM, $name, RESOURCES . 'Email.php');
    replace($DEFAULT_FROM_EMAIL, $email, RESOURCES . 'Email.php');

    $progress[] = "Details updated";
    $progress[] = "Creating Admin";

    $admin = new  Demae\Auth\Models\Shop\Administrator();
    $admin->setEmail($email);
    $admin->setName($name);
    $admin->setRole(1);
    $log = new Demae\Auth\Models\Shop\Log();
    $admin->setLog(json_encode($log->properties()));
    $admin->setAddedBy("DEMAE");
    $admin->setBranchId("DEMAE");
    $progress[] = "Admin creation: " . ($admin->register());
    $progress[] = "<a href='home' style='text-decoration:underline;'>Continue</a>";

    replace("//", "", 'index.php');
    replace("//", "", 'autoloader.php');
    replace("//", "", RESOURCES . 'PrintNodeApi.php');
}
