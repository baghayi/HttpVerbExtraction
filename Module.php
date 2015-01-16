<?php
namespace HttpVerbExtraction;

use HttpVerbExtraction\Initializer\DispatchVerbAwareInterface;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),

            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
                'HttpVerbExtraction\Initializer\DispatchVerbAwareInterface' => function($service, $sm){
                    if(!$service instanceof DispatchVerbAwareInterface)
                        return;

                    $dispatchVerb = $sm->get('HttpVerbExtraction\Rest\DispatchVerb');
                    $service->setDispatchVerb($dispatchVerb);
                },
            )
        );
    }

}


