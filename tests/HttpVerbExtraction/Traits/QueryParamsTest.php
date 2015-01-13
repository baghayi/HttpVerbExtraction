<?php
namespace HttpVerbExtraction\Test\Traits;

class QueryParamsTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_empty_array_when_not_specified()
    {
        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');

        $queryParams = $this->getObjectForTrait('HttpVerbExtraction\Traits\QueryParams');
        $result = $queryParams->getQueryParams($resourceEvent);

        $this->assertEmpty($result);
    }

    public function test_if_returns_parameter_object()
    {
        $parameterInterface = 'Zend\Stdlib\Parameters';
        $parameterMock = $this->getMock($parameterInterface);

        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');
        $resourceEvent->method('getQueryParams')
            ->willReturn($parameterMock);

        $queryParams = $this->getObjectForTrait('HttpVerbExtraction\Traits\QueryParams');
        $result = $queryParams->getQueryParams($resourceEvent);

        $this->assertInstanceOf($parameterInterface, $result);
    }

}
