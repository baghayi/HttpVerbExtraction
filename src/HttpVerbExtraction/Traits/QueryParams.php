<?php
namespace HttpVerbExtraction\Traits;

use ZF\Rest\ResourceEvent;

trait QueryParams {

    public function getQueryParams(ResourceEvent $event)
    {        
        return $event->getParam('data', array());
    }

}
