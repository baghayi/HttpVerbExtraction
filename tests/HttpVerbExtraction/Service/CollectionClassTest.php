<?php
namespace HttpVerbExtraction\Test\Service;

use HttpVerbExtraction\Service\CollectionClass;

class CollectionClassTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_collection_name()
    {
        $sampleCollectionName = 'ARandomCollectionName';
        $sampleControllerName = 'AVirtualControllerName';

        $controllerName = $this->getMockBuilder('HttpVerbExtraction\Service\ControllerName')
            ->disableOriginalConstructor()
            ->getMock();
        $controllerName->method('get')
            ->willReturn($sampleControllerName);

        $zfRestConfig = array(
            $sampleControllerName => array(
                'collection_class' => $sampleCollectionName,
            ),
        );
        $collectionClassObject = new CollectionClass($zfRestConfig, $controllerName);
        $collectionClassName = $collectionClassObject->get();

        $this->assertEquals($collectionClassName, $sampleCollectionName);
    }
}
