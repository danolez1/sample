<?php

use danolez\lib\Res\Server;
use danolez\lib\Res\Zip;
use Demae\Route\AppRoute;

require_once("autoloader.php");
$query = Server::get(Server::REQUEST_URI);
$appController = new AppRoute($query);
