<?php
namespace HttpVerbExtraction;

use ZF\Rest\ResourceEvent;

interface DispatchableInterface {

    public function dispatch(ResourceEvent $event);

}
