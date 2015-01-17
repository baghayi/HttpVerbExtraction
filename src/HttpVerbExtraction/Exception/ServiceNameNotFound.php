<?php
namespace HttpVerbExtraction\Exception;

class ServiceNameNotFound extends \Exception {

    public function __construct($verbServiceName)
    {
        $message = sprintf('Could not find service name for the requested "%s" verb.', $verbServiceName);
        parent::__construct($message);
    }

}
