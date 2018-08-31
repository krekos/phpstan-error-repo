<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');

$ip = $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname());

/** @noinspection NotOptimalRegularExpressionsInspection */
if((bool)preg_match('/^12\.345\.678\..*/', $ip)){
	$configurator->setDebugMode(true);
	$configurator->addConfig(__DIR__.'/Config/config.server.neon');
}else{
	$configurator->setDebugMode(true);
	$configurator->addConfig(__DIR__.'/Config/config.local.neon');
}


$container = $configurator->createContainer();

return $container;
