<?php

declare(strict_types=1);

namespace App\EventListener;


use ApiPlatform\Symfony\EventListener\EventPriorities;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Entity\Snippet;

class SetDefaultUserToSnippet implements EventSubscriberInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onKernelView', EventPriorities::PRE_WRITE],
        ];
    }

    public function onKernelView(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Snippet || $method !== 'POST') {
            return;
        }

        // Optionally, you can use the security component to get the current user
        $user = $this->security->getUser();
        if ($user) {
            $entity->setUser($user);
        }
    }
}
