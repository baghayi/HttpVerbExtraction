<?php
namespace HttpVerbExtraction\Traits;

use ZF\Rest\ResourceEvent;

trait InputFilter {

    
    /**
     * Retrieve the input filter, if any
     *
     * @return null|\Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter(ResourceEvent $event)
    {
        return $event->getInputFilter();
    }

}
