<?php
namespace HttpVerbExtraction\ErrorMessage;

use ZF\Rest\ResourceEvent;

class NotImplemented implements ErrorMessage {

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

    public function get(ResourceEvent $event)
    {
        $verbName = $event->getName();
        
        if(isset($this->errorMessages[$verbName]))
            return $this->errorMessages[$verbName];

        throw new \InvalidArgumentException(sprintf(
            '%s has not been setup to handle the event "%s"',
            __METHOD__,
            $event->getName()
        ));
    }

}
