<?php
include_once "modules/router.php";
include_once "modules/logging.php";

$router = new SimpleRouter();
$logger = new Logger();
$logger->path = __DIR__ . "/logs/";

$logger->ACC();

$router->addRoute('GET', '/edit', function () {
	require __DIR__ . '/views/edit.php';
	exit;
});

$router->addRoute('GET', '/in', function() {
	require __DIR__ . '/views/in.php';
	exit;
});

$router->addRoute('POST', '/in/edit', function() {
	require __DIR__ . '/api/editin.php';
	exit;
});

$router->matchRoute();
?>
