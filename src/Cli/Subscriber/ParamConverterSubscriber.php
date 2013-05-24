<?php

namespace Cli\Subscriber;

use Doctrine\Common\EventSubscriber;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ParamConverterSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['preConvert', 10],
        ];
    }

    public function preConvert(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->attributes->has('request')) {
            $request->attributes->set('request', $request);
            $request->attributes->set('argv1', ...);
        }
    }
}