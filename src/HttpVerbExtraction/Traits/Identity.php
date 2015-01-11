<?php
namespace HttpVerbExtraction\Traits;

trait Identity {

    
    public function getIdentity(ResourceEvent $event)
    {
        return $event->getIdentity();
    }

}
