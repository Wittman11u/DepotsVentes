<?php
/**
 * Created by PhpStorm.
 * User: vorace
 * Date: 08/02/16
 * Time: 00:23
 */


require 'vendor/autoload.php';

$app = new Slim\App;

require 'app/routes.php';
$app->run();