<?php
namespace HttpVerbExtraction\Rest;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\ResourceEvent;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HttpVerbExtraction\DispatchableInterface;

abstract class AbstractResourceListener extends AbstractListenerAggregate implements 
    ServiceLocatorAwareInterface {

    protected $serviceManager;

    public function setEntityClass(){}
    public function setCollectionClass(){}

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceManager;
    }


    /**
     * Attach listeners for all Resource events
     *
     * @param  EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events->attach('create',      array($this, 'dispatch'));
        $events->attach('delete',      array($this, 'dispatch'));
        $events->attach('deleteList',  array($this, 'dispatch'));
        $events->attach('fetch',       array($this, 'dispatch'));
        $events->attach('fetchAll',    array($this, 'dispatch'));
        $events->attach('patch',       array($this, 'dispatch'));
        $events->attach('patchList',   array($this, 'dispatch'));
        $events->attach('replaceList', array($this, 'dispatch'));
        $events->attach('update',      array($this, 'dispatch'));
    }



    /**
     * Dispatch an incoming event to the appropriate method
     *
     * Marshals arguments from the event parameters.
     *
     * @param  ResourceEvent $event
     * @return ApiProblem|HttpVerbExtraction\DispatchableInterface
     */
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
        $errorMessage = $this->getServiceLocator()->get('HttpVerbExtraction\ErrorMessage\NotImplemented');
        $message = $errorMessage->get($event);
        return new ApiProblem(405, $message);
    }

    private function getServiceName(ResourceEvent $event)
    {
        $config = $this->getServiceLocator()->get('Config');
        $httpVerbExtraction = $config['http-verb-extraction'];

        $controllerName = $this->getServiceLocator()->get('HttpVerbExtraction\Service\ControllerName');
        $controllerName = $controllerName->get($event);

        if(!isset($httpVerbExtraction[$controllerName]))
            return;

        $verbName = $event->getName();
        if(!isset($httpVerbExtraction[$controllerName][$verbName]))
            return;

        return $httpVerbExtraction[$controllerName][$verbName];
    }


    private function getServiceInstance($serviceName)
    {
        if(!$this->getServiceLocator()->has($serviceName))
            return;

        return $this->getServiceLocator()->get($serviceName);
    }


}
