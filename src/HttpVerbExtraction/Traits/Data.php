<?php
namespace HttpVerbExtraction\Traits;

use ZF\Rest\ResourceEvent;

trait Data {

    public function getData(ResourceEvent $event)
    {        
        return $event->getParam('data', array());
    }

}
