<?php

namespace Cli;

// interactors, extensions, exceptions, providers
use Symfony\Component\HttpFoundation\Request;
use Yolo;
use Yolo\Application;
use Yolo\DependencyInjection\ServiceControllerExtension;
use Cli\Decorator\RouteDecorator;
use Cli\Extension\MyExtension;
use Cli\Subscriber\ParamConverterSubscriber;

$container = Yolo\createContainer(
    [
        'debug' => true,
    ],
    [
        //new Yolo\DependencyInjection\MonologExtension(),
        new ServiceControllerExtension(),
        new MyExtension()
    ]
);

$app = new Application($container);

$controller = function(Request $request) {
    // some handling of the request but already converted?
};

$app
    ->getContainer()
    ->get('dispatcher')
    ->addSubscriber(new ParamConverterSubscriber())
;

decorate($app->get('/echo', $controller))
    ->convert('x', function ($_, Request $request) {})
;

return $app;

function decorate($route) {
    return new RouteDecorator($route);
}
