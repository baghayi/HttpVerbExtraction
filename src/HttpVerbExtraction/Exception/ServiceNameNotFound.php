<?php
namespace HttpVerbExtraction\Exception;

class ServiceNameNotFound extends \Exception {

    public function __construct($verbName)
    {
        $message = sprintf('Could not find service name for the requested "%s" verb.', $verbName);
        parent::__construct($message);
    }

}
