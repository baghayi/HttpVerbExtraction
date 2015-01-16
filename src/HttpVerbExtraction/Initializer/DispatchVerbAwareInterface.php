<?php
namespace HttpVerbExtraction\Initializer;

use HttpVerbExtraction\Rest\DispatchVerb;

interface DispatchVerbAwareInterface {

    public function setDispatchVerb(DispatchVerb $dispatchVerb);

    public function getDispatchVerb();

}
