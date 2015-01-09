<?php
namespace HttpVerbExtraction;

use HttpVerbExtraction\Initializer\QueryParams;
use HttpVerbExtraction\InitializerValue\QueryParams as QueryParamsValue;
use HttpVerbExtraction\DispatchableInterface;
use HttpVerbExtraction\InitializerValue\Data as DataValue;
use HttpVerbExtraction\Initializer\Data;

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

                Data::class => function($service, $sm){
                    if(!$service instanceof DispatchableInterface)
                        return;

                    $data = $sm->get(DataValue::class);
                    if($service instanceof Data)
                        $service->setData($data->get());

                },
            ], // initializers

            'factories' => [
                QueryParamsValue::class => function($sm){
                    $event = $sm->get('Application')->getMvcEvent();
                    return new QueryParamsValue($event);
                },

                DataValue::class => function($sm){
                    $pluginManager = $sm->get('ControllerPluginManager');
                    $bodyParams = $pluginManager->get('bodyParams');
                    return new DataValue($bodyParams);
                },
            ]
        ];
    }
}


