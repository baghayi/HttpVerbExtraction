<?php
namespace HttpVerbExtraction\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HttpVerbExtraction\Service\ControllerName;

class ControllerNameFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $app        = $serviceLocator->get('Application');
        $mvcEvent   = $app->getMvcEvent();
        $routeMatch = $mvcEvent->getRouteMatch();
        return new ControllerName($routeMatch);
    }
}
