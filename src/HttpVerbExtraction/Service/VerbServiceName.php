<?php
namespace HttpVerbExtraction\Service;

use HttpVerbExtraction\Service\ControllerName;
use ZF\Rest\ResourceEvent;
use HttpVerbExtraction\Exception\ServiceNotFound;

class VerbServiceName {

    /**
     * Main application config array
     * @var $config
     */
    private $config = array();

    /**
     * ControllerName service object
     * @var $controllerName
     */
    private $controllerName;


    public function __construct(array $config, ControllerName $controllerName)
    {
        $this->config         = $config;
        $this->controllerName = $controllerName;
    }


    public function get(ResourceEvent $event)
    {
        $httpVerbExtraction = $this->config['http-verb-extraction'];

        $controllerName = $this->controllerName->get($event);

        if(!isset($httpVerbExtraction[$controllerName]))
            throw new ServiceNotFound($event->getName());

        $verbName = $event->getName();
        if(!isset($httpVerbExtraction[$controllerName][$verbName]))
            throw new ServiceNotFound($verbName);

        return $httpVerbExtraction[$controllerName][$verbName];
    }

}
