<?php

declare(strict_types=1);

use App\Controller\GalleryController;
use App\Controller\HomeController;
use App\Controller\ReportController;
use App\Http\Request;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';

$request = Request::fromGlobals();
$router = new Router();

$homeController = new HomeController();
$galleryController = new GalleryController();
$reportController = new ReportController();

$router->get('/', fn () => $homeController->index($request));
$router->get('/galerie', fn () => $galleryController->index($request));
$router->post('/kontakt/odeslat', fn () => $reportController->submit($request));

$response = $router->dispatch($request);

echo $response;
