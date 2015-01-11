<?php
namespace HttpVerbExtraction\Traits;

use ZF\Rest\ResourceEvent;

trait Identity {

    
    /**
     * Retrieve the identity, if any
     *
     * Proxies to the resource event to find the identity, if not already
     * composed, and composes it.
     *
     * @return null|\ZF\MvcAuth\Identity\IdentityInterface
     */
    public function getIdentity(ResourceEvent $event)
    {
        return $event->getIdentity();
    }

}
