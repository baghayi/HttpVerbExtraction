<?php
namespace HttpVerbExtraction\InitializerValue;

use ZF\Rest\RestController;
use Zend\Mvc\MvcEvent;

final class QueryParams {

    private $event;

    public function __construct(MvcEvent $event)
    {
        $this->event = $event;
    }

    public function get()
    {
        $controller = $this->event->getTarget();
        if (!$controller instanceof RestController) {
            return null;
        }

        $request  = $this->event->getRequest();
        return $request->getQuery();
    }

}
