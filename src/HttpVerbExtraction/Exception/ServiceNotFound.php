<?php
namespace HttpVerbExtraction\Exception;

class ServiceNotFound extends \Exception {

    public function __construct($verbServiceName)
    {
        $message = sprintf('Could not find a service for the requested "%s" verb.', $verbServiceName);
        parent::__construct($message);
    }

}
