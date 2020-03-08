<?php

namespace App\Events;

use App\Entity\User;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * We want to use PasswordEncoderSubscriber::encodePassword when the return value of a controller is not a Response
     * and before any persist
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    /**
     * Encodes a User::password if and only if 
     * the return value of a controller is a User AND the method is POST
     *
     * @param ViewEvent $event
     * @return void
     */
    public function encodePassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        if ($user instanceof User && $event->getRequest()->getMethod() === "POST") {
            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
        }
    }
}
