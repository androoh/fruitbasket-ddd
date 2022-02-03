<?php

namespace FruitBasket\Infrastructure\EventListener;

use FruitBasket\Domain\Exception\DomainExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Domain Exception Listener
 * listens for Domain Exceptions and convert them to a json response
 */
class DomainExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof DomainExceptionInterface) {
            $exception = $event->getThrowable();
            $response = new JsonResponse(['errors' => [$exception->getMessage()]], 400);
            $event->setResponse($response);
        }
    }
}
