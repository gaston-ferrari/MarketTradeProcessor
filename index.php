<?php

require_once(__DIR__  . '/bootstrap.php');
require_once(__DIR__  . '/Routes.php');

$req = new \Api\Util\Request();
$routes = new Routes();

try{
    $handler = $routes->getHandler($req->getPath(), $req->getType());
    $controller = new $handler[0];
    $res = $controller->$handler[1]($req);
    echo json_encode($res);
} catch (Exception $ex) {
    http_response_code(500);
    echo $ex->getMessage();
}
