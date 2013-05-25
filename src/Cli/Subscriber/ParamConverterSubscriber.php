<?php

namespace Cli\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouteCollection;

class ParamConverterSubscriber implements EventSubscriberInterface
{
    private $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['preConvert', 10]],
        ];
    }

    public function preConvert(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $route = $this->routes->get($request->attributes->get('_route'));
        $converters = $route->getOption('_converters');

        foreach($converters as $name => $converter) {
            if ($request->attributes->has($name)) {
                $request->attributes->set(
                    $name,
                    $converter(
                        $request->attributes->get($name),
                        $request
                    )
                );
            }
        }
    }
}