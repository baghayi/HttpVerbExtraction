<?php
namespace HttpVerbExtraction\Test\Service;

use HttpVerbExtraction\Service\ControllerName;
use Zend\Mvc\Router\RouteMatch;

class ControllerNameTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returns_null_when_no_controller_found()
    {
        $routeMatch = new RouteMatch(array());
        $controllerName = new ControllerName($routeMatch);

        $result = $controllerName->get();

        $this->assertNull($result);
    }

    public function test_if_returns_controller_name()
    {
        $controllerName = "AVirtualControllerName";
        $routeMatch = new RouteMatch(array('controller' => $controllerName));

        $controllerNameObject = new ControllerName($routeMatch);
        $result = $controllerNameObject->get();

        $this->assertEquals($result, $controllerName);
    }


}
