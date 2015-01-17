<?php
namespace HttpVerbExtraction\Exception;

class ServiceNotFound extends \Exception {

    public function __construct($serviceName)
    {
        $message = sprintf('Could not find the requested "%s" service.', $serviceName);
        parent::__construct($message);
    }

}
