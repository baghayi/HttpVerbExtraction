<?php
namespace HttpVerbExtraction\Service;

use ZF\Rest\ResourceEvent;

/**
* The entity_class config for the calling controller zf-rest config
*/
final class EntityClass {

    private $zfRestConfig = array();

    private $controllerName;

    public function __construct(array $zfRestConfig, ControllerName $controllerName)
    {
        $this->zfRestConfig   = $zfRestConfig;
        $this->controllerName = $controllerName;
    }

    public function get(ResourceEvent $event)
    {
        $controllerName = $this->controllerName->get($event);

        if(!isset($this->zfRestConfig[$controllerName]))
            return;

        if(!isset($this->zfRestConfig[$controllerName]['entity_class']))
            return;

        return $this->zfRestConfig[$controllerName]['entity_class'];
    }

}
