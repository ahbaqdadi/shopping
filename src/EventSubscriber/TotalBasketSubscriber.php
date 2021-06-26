<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\ShoppingBasket;
use App\Infrastructure\Bridge\TotalBasket;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TotalBasketSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['calculateTotalBasket', EventPriorities::POST_WRITE],
        ];
    }

    public function calculateTotalBasket(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($entity instanceof TotalBasket && (Request::METHOD_POST === $method || Request::METHOD_PUT === $method)) {
            /**
             * @var ShoppingBasket $entity
             */
            $totalPrice = 0;
            foreach ($entity->getProducts() as $productBasket) {
                $totalPrice+=  $productBasket->getProduct()->getPrice() * $productBasket->getQuantity();
            }

            $entity->setTotal($totalPrice);
        }
    }
}
