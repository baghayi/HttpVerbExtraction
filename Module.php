<?php
namespace HttpVerbExtraction;

use HttpVerbExtraction\Initializer\QueryParams;
use HttpVerbExtraction\InitializerValue\QueryParams as QueryParamsValue;
use HttpVerbExtraction\DispatchableInterface;

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
        return [
            'initializers' => [
                QueryParams::class => function($service, $sm){
                    if(!$service instanceof DispatchableInterface)
                        return;

                    $params = $sm->get(QueryParamsValue::class);
                    if($service instanceof QueryParams)
                        $service->setQueryParams($params->get());
                },
            ], // initializers

            'factories' => [
                QueryParamsValue::class => function($sm){
                    $event = $sm->get('Application')->getMvcEvent();
                    return new QueryParamsValue($event);
                },
            ]
        ];
    }
}


