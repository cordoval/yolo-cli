<?php

namespace Cli\Decorator;

class RouteDecorator
{
    private $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    function convert($name, $converter) {
        $converters = $this->route->getOption('_converters');
        $converters[$name] = $converter;
        $this->route->setOption('_converters', $converters);

        return $this;
    }
}