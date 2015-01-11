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


    protected $errorMessages = array(
        'create'      => 'The POST method has not been defined',
        'delete'      => 'The DELETE method has not been defined for individual resources',
        'deleteList'  => 'The DELETE method has not been defined for collections',
        'fetch'       => 'The GET method has not been defined for individual resources',
        'fetchAll'    => 'The GET method has not been defined for collections',
        'patch'       => 'The PATCH method has not been defined for individual resources',
        'patchList'   => 'The PATCH method has not been defined for collections',
        'replaceList' => 'The PUT method has not been defined for collections',
        'update'      => 'The PUT method has not been defined for individual resources',
    );

    /**
     * @var ResourceEvent
     */
    protected $event;

    /**
     * The entity_class config for the calling controller zf-rest config
     */
    protected $entityClass;

    /**
     * The collection_class config for the calling controller zf-rest config
     */
    protected $collectionClass;


    /**
     * Input filter, if discovered in the resource event.
     *
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;


    private $serviceManager;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceManager;
    }

    /**
     * Set the entity_class for the controller config calling this resource
     */
    public function setEntityClass($className)
    {
        $this->entityClass = $className;
        return $this;
    }

    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function setCollectionClass($className)
    {
        $this->collectionClass = $className;
        return $this;
    }

    public function getCollectionClass()
    {
        return $this->collectionClass;
    }

    /**
     * Retrieve the current resource event, if any
     *
     * @return ResourceEvent
     */
    public function getEvent()
    {
        return $this->event;
    }


    /**
     * Retrieve the input filter, if any
     *
     * Proxies to the resource event to find the input filter, if not already
     * composed, and composes it.
     *
     * @return null|\Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $event = $this->getEvent();
        if (! $event instanceof ResourceEvent) {
            return null;
        }

        $this->inputFilter = $event->getInputFilter();
        return $this->inputFilter;
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

        if($serviceName instanceof DispatchableInterface)
            return $serviceName->dispatch($event);

        $service = $this->getServiceInstance($serviceName);

        if($service instanceof DispatchableInterface)
            return $service->dispatch($event);

        $errorMessage = $this->getErrorMessage($event);
        return new ApiProblem(405, $errorMessage);
    }

    private function getErrorMessage(ResourceEvent $event)
    {
        $eventName = $event->getName();
        return $this->errorMessages[$eventName];
    }

    private function getServiceName(ResourceEvent $event)
    {
        $eventName = $event->getName();

        if(!method_exists($this, $eventName))
            return;

        return $this->$eventName();
    }

    private function getServiceInstance($serviceName)
    {
        if(!$this->getServiceLocator()->has($serviceName))
            return;

        return $this->getServiceLocator()->get($serviceName);
    }

    /**
     * Create a resource
     *
     * @return String
     */
    public function create(){}


    /**
     * Delete a resource
     *
     * @return String
     */
    public function delete(){}


    /**
     * Delete a collection, or members of a collection
     *
     * @return String
     */
    public function deleteList(){}


    /**
     * Fetch a resource
     *
     * @return String
     */
    public function fetch(){}


    /**
     * Fetch all or a subset of resources
     *
     * @return String
     */
    public function fetchAll(){}


    /**
     * Patch (partial in-place update) a resource
     *
     * @return String
     */
    public function patch(){}


    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @return String
     */
    public function patchList(){}


    /**
     * Replace a collection or members of a collection
     *
     * @return String
     */
    public function replaceList(){}

    /**
     * Update a resource
     *
     * @return String
     */
    public function update(){}


}
