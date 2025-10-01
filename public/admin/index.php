<?php

declare(strict_types=1);

use App\Controller\AdminController;
use App\Http\Request;
use App\Router;

require __DIR__ . '/../../vendor/autoload.php';

$globalRequest = Request::fromGlobals();
$path = $globalRequest->getPath();
$internalPath = preg_replace('#^/admin#', '', $path) ?: '/';
$request = $globalRequest->withPath($internalPath);

$router = new Router();
$controller = new AdminController();

$router->get('/', fn () => $controller->dashboard($request));
$router->get('/login', fn () => $controller->login($request));
$router->post('/login', fn () => $controller->login($request));
$router->get('/logout', fn () => $controller->logout($request));
$router->post('/events/save', fn () => $controller->saveEvent($request));
$router->post('/events/delete', fn () => $controller->deleteEvent($request));
$router->post('/gallery/save', fn () => $controller->saveGalleryItem($request));
$router->post('/gallery/delete', fn () => $controller->deleteGalleryItem($request));
$router->post('/contacts/delete', fn () => $controller->deleteContact($request));
$router->post('/pages/save', fn () => $controller->savePage($request));

$response = $router->dispatch($request);

echo $response;
