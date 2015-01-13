<?php
namespace HttpVerbExtraction\Test\Traits;

class InputFilterTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_inputfilter_object()
    {
        $inputFilterInterface = 'Zend\InputFilter\InputFilterInterface';
        $inputFilterMock = $this->getMock($inputFilterInterface);

        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');
        $resourceEvent->method('getInputFilter')
            ->willReturn($inputFilterMock);

        $inputFilter = $this->getObjectForTrait('HttpVerbExtraction\Traits\InputFilter');
        
        $returnedValue = $inputFilter->getInputFilter($resourceEvent);
        $this->assertInstanceOf($inputFilterInterface, $returnedValue);
    }

}
