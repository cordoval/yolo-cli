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

$app
    ->getContainer()
    ->get('dispatcher')
    ->addSubscriber(new ParamConverterSubscriber(
        $app->getContainer()->get('routes')
    ))
;

$converter = function ($_, Request $request) {

};

decorate($app->get('/echo', 'board.interactor'))
    ->convert('request', $converter)
;

return $app;

function decorate($route) {
    return new RouteDecorator($route);
}
