<?php
namespace HttpVerbExtraction\Service;

/**
* The collection_class config for the calling controller zf-rest config
*/
final class CollectionClass {

    private $zfRestConfig = array();

    private $controllerName;

    public function __construct(array $zfRestConfig, ControllerName $controllerName)
    {
        $this->zfRestConfig   = $zfRestConfig;
        $this->controllerName = $controllerName;
    }

    public function get()
    {
        $controllerName = $this->controllerName->get();

        if(!isset($this->zfRestConfig[$controllerName]))
            return;

        if(!isset($this->zfRestConfig[$controllerName]['collection_class']))
            return;

        return $this->zfRestConfig[$controllerName]['collection_class'];
    }

}
