<?php

use danolez\lib\Res\Server\Server;

function isAssoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function validateEmail(string $email = null)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;
    else return true;
}

function validatePhone(string $phone = null)
{
    if (is_numeric(($phone))) {
        if (strlen($phone) > 9 && strlen($phone) < 16)
            return true;
        else return false;
    } else return false;
}

function randomUsername($string, $delimiter = " ")
{
    $firstPart = strstr(strtolower($string), $delimiter, true);
    $secondPart = substr(strstr(strtolower($string), $delimiter, false), 0, 3);
    $nrRand = rand(0, 100);

    $username = trim($firstPart) . trim($secondPart) . trim($nrRand);
    return $username;
}

function removeSpace($string)
{
    return str_replace(" ", "", $string);
}


function fJson($json)
{
    $json = str_replace('&quot;', '"', $json);
    return json_decode($json);
}

function purify(string $p)
{
    $p = trim($p);
    $p = stripslashes($p);
    $p = stripcslashes($p);
    $p = strip_tags($p);
    $p = htmlentities($p);
    return $p;
}

function keepFormValues($input)
{
    $script = '<script type="text/javascript" hidden>';
    $script .= "loadFormData(" . json_encode($input) . ");";
    $script .= '</script>';
    echo $script;
}

function isEmpty($var)
{
    return (is_null($var) || $var == "");
}
function returnJsFunc($input)
{
    $script = '<script type="text/javascript" hidden>';
    $script .= "($input);";
    $script .= '</script>';
    echo $script;
}

function fromDbJson($object)
{
    return json_decode(str_replace('&quot;', '"', $object));
}

function daysOfWeek()
{
    return array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
}

function toDbJson($object)
{
    if (!isEmpty($object))
        return (str_replace('"', '&quot;', json_encode($object)));
}

function uploadFile($inputName, $path = "images/", $fileName = null)
{
    $file = $_FILES[$inputName]['name'];
    $folder =  $path;
    if (!is_dir($folder)) mkdir($folder);
    $fileName = $fileName ?? $file;
    $target = $folder . $fileName  . "." . pathinfo($file, PATHINFO_EXTENSION);
    $upload = move_uploaded_file($_FILES[$inputName]['tmp_name'], $target);
    return $upload ? $target : null;
}

function iterativeBase64Encode($data, $k)
{
    $rt = $data;
    for ($i = 0; $i < $k; $i++) {
        $rt =  base64_encode($rt);
    }
    return $rt;
}
function iterativeBase64Decode($data, $k = 0)
{
    $rt = $data;
    for ($i = 0; $i < $k; $i++) {
        $rt =  base64_decode($rt);
    }
    return $rt;
}

function maskString($number, $left = 4)
{
    // check for input
    $mask_number =  str_repeat("*", strlen($number) - $left) . substr($number, -$left);
    return $mask_number;
}

function smartWordWrap($phrase)
{
    $return = "";
    $location = explode(' ', $phrase);
    for ($i = 0; $i < count($location); $i++) {
        $return .= $location[$i] . " ";
        if ($i == round(count($location) / 2) - 1) {
            $return .= "<br>";
        }
    }
    return $return;
}
