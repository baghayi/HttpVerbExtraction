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
     * @return mixed
     */
    public function dispatch(ResourceEvent $event)
    {
        $this->event = $event;
        switch ($event->getName()) {
            case 'create':
                return $this->dispatchCreate($event);
            case 'delete':
                return $this->dispatchDelete($event);
            case 'deleteList':
                return $this->dispatchDeleteList($event);
            case 'fetch':
                $id   = $event->getParam('id', null);
                return $this->fetch($id);
            case 'fetchAll':
                return $this->dispatchFetchAll($event);
            case 'patch':
                $id   = $event->getParam('id', null);
                $data = $event->getParam('data', array());
                return $this->patch($id, $data);
            case 'patchList':
                $data = $event->getParam('data', array());
                return $this->patchList($data);
            case 'replaceList':
                $data = $event->getParam('data', array());
                return $this->replaceList($data);
            case 'update':
                $id   = $event->getParam('id', null);
                $data = $event->getParam('data', array());
                return $this->update($id, $data);
            default:
                throw new Exception\RuntimeException(sprintf(
                    '%s has not been setup to handle the event "%s"',
                    __METHOD__,
                    $event->getName()
                ));
        }
    }

    /**
     * Create a resource
     *
     * @return String
     */
    public function create(){}

    private function dispatchCreate(ResourceEvent $event)
    {
        $serviceName = $this->create();
        $errorMessage = 'The POST method has not been defined';

        return $this->dispatchService($serviceName, $event, $errorMessage);
    }

    /**
     * Delete a resource
     *
     * @return String
     */
    public function delete(){}

    private function dispatchDelete(ResourceEvent $event)
    {
        $serviceName = $this->delete();
        $errorMessage = 'The DELETE method has not been defined for individual resources';

        return $this->dispatchService($serviceName, $event, $errorMessage);
    }


    /**
     * Delete a collection, or members of a collection
     *
     * @return String
     */
    public function deleteList(){}

    private function dispatchDeleteList(ResourceEvent $event)
    {
        $serviceName = $this->deleteList();
        $errorMessage = 'The DELETE method has not been defined for collections';

        return $this->dispatchService($serviceName, $event, $errorMessage);
    }

    private function dispatchService($serviceName, ResourceEvent $event, $errorMessage)
    {
        if($serviceName instanceof DispatchableInterface)
            return $serviceName->dispatch($event);

        if(!$this->getServiceLocator()->has($serviceName))
            return new ApiProblem(405, $errorMessage);

        $service = $this->getServiceLocator()->get($serviceName);
        if($service instanceof DispatchableInterface)
            return $service->dispatch($event);

        return new ApiProblem(405, $errorMessage);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @return String
     */
    public function fetchAll(){}

    private function dispatchFetchAll(ResourceEvent $event)
    {
        $serviceName = $this->fetchAll();

        if($serviceName instanceof DispatchableInterface)
            return $serviceName->dispatch($event);

        if(!$this->getServiceLocator()->has($serviceName))
            return new ApiProblem(405, 'The GET method has not been defined for collections');

        $service = $this->getServiceLocator()->get($serviceName);
        if($service instanceof DispatchableInterface)
            return $service->dispatch($event);

        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }



}
