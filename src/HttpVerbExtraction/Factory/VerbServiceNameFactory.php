<?php
namespace HttpVerbExtraction\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HttpVerbExtraction\Service\VerbServiceName;

class VerbServiceNameFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config         = $serviceLocator->get('Config');
        $controllerName = $serviceLocator->get('HttpVerbExtraction\Service\ControllerName');
        return new VerbServiceName($config, $controllerName);
    }
}
