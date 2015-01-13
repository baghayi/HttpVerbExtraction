<?php
namespace HttpVerbExtraction\Test\Traits;

class IdentifierTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_identifier_as_null_when_not_specified()
    {
        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');

        $identifier = $this->getObjectForTrait('HttpVerbExtraction\Traits\Identifier');

        $id = $identifier->getIdentifier($resourceEvent);
        $this->assertNull($id);
    }

    public function test_if_returnes_specified_id_as_identifier()
    {
        $expectedId = 5;
        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');
        $resourceEvent->method('getParam')
            ->willReturn($expectedId);

        $identifier = $this->getObjectForTrait('HttpVerbExtraction\Traits\Identifier');
        
        $id = $identifier->getIdentifier($resourceEvent);
        $this->assertEquals($id, $expectedId);
    }

}
