<?php

require_once(__DIR__  . '/ClassLoader.php');

$classLoader = new \ClassLoader('Api', __DIR__ . '/src');
$classLoader->registerLoader();

