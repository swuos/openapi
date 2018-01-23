<?php

ini_set('yaf.name_separator', '_');

define('ROOT_PATH', dirname(__DIR__));

define('APPLICATION_PATH', ROOT_PATH . '/application');

$application = new Yaf\Application(ROOT_PATH . '/config/application.ini', ini_get('yaf.environ'));

$application->bootstrap()->run();