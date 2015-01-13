<?php
namespace HttpVerbExtraction\Test\Service;

use HttpVerbExtraction\Service\CollectionClass;

class CollectionClassTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_collection_name()
    {
        $sampleCollectionName = 'ARandomCollectionName';
        $sampleControllerName = 'AVirtualControllerName';
        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');

        $controllerName = $this->getMock('HttpVerbExtraction\Service\ControllerName');
        $controllerName->method('get')
            ->willReturn($sampleControllerName);

        $zfRestConfig = array(
            $sampleControllerName => array(
                'collection_class' => $sampleCollectionName,
            ),
        );
        $collectionClassObject = new CollectionClass($zfRestConfig, $controllerName);
        $collectionClassName = $collectionClassObject->get($resourceEvent);

        $this->assertEquals($collectionClassName, $sampleCollectionName);
    }
}
