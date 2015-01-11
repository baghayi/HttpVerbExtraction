<?php
namespace HttpVerbExtraction\Traits;

use ZF\Rest\ResourceEvent;

trait Identifier {

    public function getIdentifier(ResourceEvent $event)
    {
        return $event->getParam('id', null);
    }

}
