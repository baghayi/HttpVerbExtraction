<?php
chdir(__DIR__);
if (file_exists(__DIR__ . '/../vendor/autoload.php')){
    require_once __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../../../vendor/autoload.php';
} else{
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

$autoloader = new Zend\Loader\StandardAutoloader(array('autoregister_zf' => true));
$autoloader->registerNamespace('HttpVerbExtraction', __DIR__ . '/../src/HttpVerbExtraction');
$autoloader->register();
