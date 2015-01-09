<?php
namespace HttpVerbExtraction\InitializerValue;

use ZF\ContentNegotiation\ControllerPlugin\BodyParams;

final class Data {

    private $bodyParams;

    public function __construct(BodyParams $bodyParams)
    {
        $this->bodyParams = $bodyParams;
    }

    public function get()
    {
        $bodyParams = $this->bodyParams;
        return $bodyParams();
    }

}
