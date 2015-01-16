<?php
namespace HttpVerbExtraction\Rest;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use ZF\Rest\ResourceEvent;
use HttpVerbExtraction\DispatchableInterface;
use HttpVerbExtraction\Rest\DispatchVerb;
use HttpVerbExtraction\Initializer\DispatchVerbAwareInterface;

abstract class AbstractResourceListener 
    extends AbstractListenerAggregate 
    implements DispatchVerbAwareInterface
     {

    private $dispatchVerb;

    public function setEntityClass(){}
    public function setCollectionClass(){}

    public function setDispatchVerb(DispatchVerb $dispatchVerb) 
    {
        $this->dispatchVerb = $dispatchVerb;
    }

    public function getDispatchVerb()
    {
        return $this->dispatchVerb;
    }


    /**
     * Attach listeners for all Resource events
     *
     * @param  EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events->attach('create',      array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('delete',      array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('deleteList',  array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('fetch',       array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('fetchAll',    array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('patch',       array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('patchList',   array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('replaceList', array($this->getDispatchVerb(), 'dispatch'));
        $events->attach('update',      array($this->getDispatchVerb(), 'dispatch'));
    }

}
