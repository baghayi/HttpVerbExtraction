<?php
namespace HttpVerbExtraction\Rest;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\ResourceEvent;
use HttpVerbExtraction\Service\VerbServiceName;
use HttpVerbExtraction\ErrorMessage\ErrorMessage;
use HttpVerbExtraction\DispatchableInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DispatchVerb implements ServiceLocatorAwareInterface {

    private $errorMessage;

    private $verbServiceName;

    private $serviceManager;

    public function __construct(ErrorMessage $errorMessage, VerbServiceName $verbServiceName)
    {
        $this->errorMessage    = $errorMessage;
        $this->verbServiceName = $verbServiceName;
    }


    public function dispatch(ResourceEvent $event)
    {
        $serviceName  = $this->getServiceName($event);

        $service = $this->getServiceInstance($serviceName);

        if($service instanceof DispatchableInterface)
            return $service->dispatch($event);

        return $this->getErrorMessage($event);
    }

    private function getErrorMessage(ResourceEvent $event)
    {
        $message = $this->errorMessage->get($event);
        return new ApiProblem(405, $message);
    }

    private function getServiceName(ResourceEvent $event)
    {
        return $this->verbServiceName->get($event);
    }


    private function getServiceInstance($serviceName)
    {
        if(!$this->getServiceLocator()->has($serviceName))
            return;

        return $this->getServiceLocator()->get($serviceName);
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceManager;
    }

}
