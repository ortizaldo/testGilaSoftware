<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');
    // $app->post('/users', \App\Action\UserCreateAction::class);
    $app->post('/user/new', \App\Action\UserCreateAction::class);
    $app->post('/car/new', \App\Action\CarAction\CreateCarAction::class);
    $app->post('/type-car/new', \App\Action\CarAction\CreateTypeCarAction::class);
};