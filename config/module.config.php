<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            'HttpVerbExtraction\Service\ControllerName' => 'HttpVerbExtraction\Service\ControllerName',
        ),
        'factories' => array(
            'HttpVerbExtraction\Service\CollectionClass' => 'HttpVerbExtraction\Service\CollectionClassFactory',
            'HttpVerbExtraction\Service\EntityClass'     => 'HttpVerbExtraction\Service\EntityClassFactory',
        )
    ),
);
