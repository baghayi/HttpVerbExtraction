<?php
namespace HttpVerbExtraction\Service;

use Zend\Mvc\Router\RouteMatch;

class ControllerName {

    private $routeMatch;

    public function __construct(RouteMatch $routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function get()
    {
        return $this->routeMatch->getParam('controller', null);
    }

}
