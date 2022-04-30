<?php


namespace App\EventSubscriber;


use App\Service\StatsVisites;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class VisitSubscriber implements EventSubscriberInterface
{

    /**
     * @var StatsVisites
     */
    private StatsVisites $statsVisites;

    public function __construct(
        StatsVisites $statsVisites
    )
    {
        $this->statsVisites = $statsVisites;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->statsVisites->addVisite($event->getRequest()->getPathInfo());
    }


}