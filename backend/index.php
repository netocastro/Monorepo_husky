<?php

require_once __DIR__ . "/vendor/autoload.php";

use Stonks\Router\Router;

$route = new Router(BASE_PATH);

$route->namespace("Source\Controllers");

$route->group(null);

$route->get('/doc', "Web:doc", "web.doc");
$route->get('/', function () {

   echo "<h1 style='text-align:center; margin-top:250px;'>Em breve na nessa Rota Home estará a pagina da documentação</h1>";

}, "web.home");

$route->group('web');

$route->post('/filterDeliveries', "Web:filterDeliveries", "web.filterDeliveries");
$route->post('/changeStatusDelivery', "Web:changeStatusDelivery", "web.changeStatusDelivery");
$route->post('/changeMotoboyDelivery', "Web:changeMotoboyDelivery", "web.changeMotoboyDelivery");

$route->group('status');

$route->get('/', "StatusController:index", "status.index");
$route->get('/{id}', "StatusController:show", "status.show");
$route->post('/', "StatusController:store", "status.store");
$route->put('/{id}', "StatusController:update", "status.update");
$route->delete('/{id}', "StatusController:delete", "status.delete");

$route->group('user');

$route->get('/', "UserController:index", "user.index");
$route->get('/{id}', "UserController:show", "user.show");
$route->post('/', "UserController:store", "user.store");
$route->put('/{id}', "UserController:update", "user.update");
$route->delete('/{id}', "UserController:delete", "user.delete");

$route->group('motoboy');

$route->get('/', "MotoboyController:index", "motoboy.index");
$route->get('/{id}', "MotoboyController:show", "motoboy.show");
$route->post('/', "MotoboyController:store", "motoboy.store");
$route->put('/{id}', "MotoboyController:update", "motoboy.update");
$route->delete('/{id}', "MotoboyController:delete", "motoboy.delete");

$route->group('delivery');

$route->get('/', "DeliveryController:index", "delivery.index");
$route->get('/{id}', "DeliveryController:show", "delivery.show");
$route->post('/', "DeliveryController:store", "delivery.store");
$route->put('/{id}', "DeliveryController:update", "delivery.update");
$route->delete('/{id}', "DeliveryController:delete", "delivery.delete");

$route->get('/status/{id}', "DeliveryController:status", "delivery.status");

$route->dispatch();

if ($route->error()) {
   echo "Error: " . $route->error();
}
