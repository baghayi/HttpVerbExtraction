<?php
namespace HttpVerbExtraction\ErrorMessage;

use ZF\Rest\ResourceEvent;

interface ErrorMessage {

    public function get(ResourceEvent $event);

}
