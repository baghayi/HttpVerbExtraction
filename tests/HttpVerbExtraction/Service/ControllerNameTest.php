<?php
namespace HttpVerbExtraction\Test\Service;

use HttpVerbExtraction\Service\ControllerName;

class ControllerNameTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_null_when_no_controller_found()
    {
        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');
        $controllerName = new ControllerName();

        $result = $controllerName->get($resourceEvent);

        $this->assertNull($result);
    }

    public function test_if_returns_controller_name()
    {
        $controllerName = "AVirtualConctrollerName";

        $routeMatchMock = $this->getMockBuilder('Zend\Mvc\Router\RouteMatch')
            ->disableOriginalConstructor()
            ->getMock();

        $routeMatchMock->method('getParam')
             ->with($this->equalTo('controller'))
             ->willReturn($controllerName);

        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');
        $resourceEvent->method('getRouteMatch')
            ->willReturn($routeMatchMock);


        $controllerNameObject = new ControllerName();
        $result = $controllerNameObject->get($resourceEvent);

        $this->assertEquals($result, $controllerName);
    }


}
