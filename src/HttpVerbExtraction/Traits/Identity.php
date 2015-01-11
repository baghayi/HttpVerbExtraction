<?php
namespace HttpVerbExtraction\Traits;

use ZF\Rest\ResourceEvent;

trait Identity {

    
    public function getIdentity(ResourceEvent $event)
    {
        return $event->getIdentity();
    }

}
