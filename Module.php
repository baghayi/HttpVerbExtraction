<?php
namespace HttpVerbExtraction;

use HttpVerbExtraction\Service\EntityClass;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
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
            'factories' => array(
                'HttpVerbExtraction\Service\EntityClass' => function($sm){
                    $config         = $sm->get('Config');
                    $zfRestConfig   = isset($config['zf-rest'])? $config['zf-rest'] : array();
                    $controllerName = $sm->get('HttpVerbExtraction\Service\ControllerName');
                    return new EntityClass($zfRestConfig, $controllerName);
                },
            ),
        );
    }

}


