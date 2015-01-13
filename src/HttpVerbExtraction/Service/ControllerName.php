<?php
namespace HttpVerbExtraction\Service;

use ZF\Rest\ResourceEvent;
use Zend\Mvc\Router\RouteMatch;

class ControllerName {

    public function get(ResourceEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        if(!$routeMatch instanceof RouteMatch)
            return null;

        return $routeMatch->getParam('controller', null);
    }

}
