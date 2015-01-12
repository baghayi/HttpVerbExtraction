<?php
namespace HttpVerbExtraction\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HttpVerbExtraction\Service\EntityClass;

class EntityClassFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config         = $serviceLocator->get('Config');
        $zfRestConfig   = isset($config['zf-rest'])? $config['zf-rest'] : array();
        $controllerName = $serviceLocator->get('HttpVerbExtraction\Service\ControllerName');
        return new EntityClass($zfRestConfig, $controllerName);
    }
}
