<?php
namespace HttpVerbExtraction\Service;

use ZF\Rest\ResourceEvent;

final class ControllerName {

    public function get(ResourceEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        return $routeMatch->getParam('controller', null);
    }

}
