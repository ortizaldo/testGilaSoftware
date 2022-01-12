<?php
use Slim\App;

return function (App $app) {
    $app->post('/user/new', \App\Action\UserCreateAction::class);
    
    $app->get('/car/all', \App\Action\CarAction\ListCarAction::class);
    $app->post('/car/new', \App\Action\CarAction\CreateCarAction::class);
    $app->patch('/car/{id}', \App\Action\CarAction\UpdateCarAction::class);
    $app->delete('/car/{id}', \App\Action\CarAction\DeleteCarAction::class);

    $app->post('/type-car/new', \App\Action\CarAction\CreateTypeCarAction::class);
};