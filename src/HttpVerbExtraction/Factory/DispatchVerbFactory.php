<?php
namespace HttpVerbExtraction\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HttpVerbExtraction\Rest\DispatchVerb;

class DispatchVerbFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $errorMessage    = $serviceLocator->get('HttpVerbExtraction\ErrorMessage\ErrorMessage');
        $verbServiceName = $serviceLocator->get('HttpVerbExtraction\Service\VerbServiceName');
        return new DispatchVerb($errorMessage, $verbServiceName);
    }
}
