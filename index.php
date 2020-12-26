<?php

use danolez\lib\Res\Server\Server;
use danolez\lib\Res\Zip\Zip;
use Demae\Route\AppRoute\AppRoute;

header("Cache-Control: max-age=3000, must-revalidate");

require_once("autoloader.php");

$query = Server::get(Server::REQUEST_URI);
$appController = new AppRoute($query);
