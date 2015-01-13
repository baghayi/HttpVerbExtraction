<?php
namespace HttpVerbExtraction\Test\Traits;

class DataTest extends \PHPUnit_Framework_TestCase {


    public function test_if_returns_empty_array_when_not_specified()
    {
        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');

        $data = $this->getObjectForTrait('HttpVerbExtraction\Traits\Data');

        $data = $data->getData($resourceEvent);
        $this->assertEmpty($data);
    }

    public function test_if_returnes_specified_data()
    {
        $expectedData = array(
            'title' => 'Some test title',
            'body'  => 'Some greate content',
        );
        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');
        $resourceEvent->method('getParam')
            ->with($this->equalTo('data'))
            ->willReturn($expectedData);

        $data = $this->getObjectForTrait('HttpVerbExtraction\Traits\Data');
        
        $data = $data->getData($resourceEvent);
        $this->assertEquals($data, $expectedData);
    }

}
