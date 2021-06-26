<?php


namespace App\EventSubscriber;


use App\Infrastructure\Bridge\ShoppingBasketValidator;
use App\Service\ShoppingBasketHandler;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\ShoppingBasket;
use App\Infrastructure\Bridge\TotalBasket;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ValidateShoppingBasket implements EventSubscriberInterface
{

    public function __construct(private ShoppingBasketHandler $handler)
    {}

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['validateShoppingBasket', EventPriorities::POST_WRITE],
        ];
    }

    public function validateShoppingBasket(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($entity instanceof ShoppingBasketValidator && (Request::METHOD_POST === $method || Request::METHOD_PUT === $method)) {
            $this->handler->checkUniqueProducts($entity);
        }
    }

}
