<?php

namespace App\Events\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    public function updateData(JWTCreatedEvent $event)
    {
        // $event->getUser();
        // $event->getData();
        // $event->setData(["name" => "toto"]);
    }
}
