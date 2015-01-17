<?php
namespace HttpVerbExtraction\Test\Service;

use HttpVerbExtraction\Service\EntityClass;

class EntityClassTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_entity_name()
    {
        $sampleEntityName = 'ARandomEntityName';
        $sampleControllerName = 'AVirtualControllerName';

        $controllerName = $this->getMockBuilder('HttpVerbExtraction\Service\ControllerName')
            ->disableOriginalConstructor()
            ->getMock();
        $controllerName->method('get')
            ->willReturn($sampleControllerName);

        $zfRestConfig = array(
            $sampleControllerName => array(
                'entity_class' => $sampleEntityName,
            ),
        );
        $entityClassObject = new EntityClass($zfRestConfig, $controllerName);
        $entityClassName = $entityClassObject->get();

        $this->assertEquals($entityClassName, $sampleEntityName);
    }
}
