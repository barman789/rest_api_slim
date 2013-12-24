<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
error_reporting(E_ALL);

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'mode' => 'development'
    //'mode' => 'production'
));

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

//Authenticate
$app->post('/authenticate', function () use ($app) {
    require 'Models/UserModel.php';
    $userModel = new UserModel($app);
    $userModel->authenticate();
});

//Get All Records
$app->get('/properties', function () use ($app) {
    require 'Models/PropertyModel.php';
    $propertyModel = new PropertyModel($app);
    $propertyModel->getAll();
});

//Add a Record
$app->post('/properties', function () use ($app) {
    require 'Models/PropertyModel.php';
    $propertyModel = new PropertyModel($app);
    $propertyModel->add();
});

//Get Details of 1 Record
$app->get('/properties/:id', function ($property_id) use ($app) {
    require 'Models/PropertyModel.php';
    $propertyModel = new PropertyModel($app);
    $propertyModel->getDetail($property_id);
})->conditions(array('id' => '[0-9]'));

//Edit a Record
$app->put('/properties/:id', function ($property_id) use ($app) {
    require 'Models/PropertyModel.php';
    $propertyModel = new PropertyModel($app);
    $propertyModel->edit($property_id);
})->conditions(array('id' => '[0-9]'));

//Delete a Record
$app->delete('/properties/:id', function ($property_id) use ($app) {
    require 'Models/PropertyModel.php';
    $propertyModel = new PropertyModel($app);
    $propertyModel->delete($property_id);
})->conditions(array('id' => '[0-9]'));

//404 Message
$app->notFound(function () use ($app) {
    $app->response->status(200);
    $app->response->headers->set('Content-Type', 'application/json');
    $body = '{"error":"Not Found"}';
    $app->response->setBody($body);
    $app->stop();
});

$app->run();