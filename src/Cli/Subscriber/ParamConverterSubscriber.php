<?php

namespace Cli\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ParamConverterSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['preConvert', 10]],
        ];
    }

    public function preConvert(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->attributes->has('request')) {
            $request->attributes->set('request', $request);
            //$request->attributes->set('argv1', ...);
        }
    }
}