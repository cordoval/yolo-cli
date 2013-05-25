<?php

namespace Cli\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

class ControllerResolver implements ControllerResolverInterface
{
    protected $resolver;
    protected $container;

    public function __construct(ControllerResolverInterface $resolver, ContainerInterface $container)
    {
        $this->resolver = $resolver;
        $this->container = $container;
    }

    public function getController(Request $request)
    {
        $controller = $request->attributes->get('_controller', null);

        if (!is_string($controller) || is_null($this->container->has($controller))) {
            return $this->resolver->getController($request);
        }

        if (!is_callable($this->container->get($controller))) {
            throw new \InvalidArgumentException(sprintf('Service "%s" is not callable.', $controller));
        }

        return $this->container->get($controller);
    }

    public function getArguments(Request $request, $controller)
    {
        return $this->resolver->getArguments($request, $controller);
    }
}