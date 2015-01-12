<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            'HttpVerbExtraction\Service\ControllerName' => 'HttpVerbExtraction\Service\ControllerName',
        ),
        'factories' => array(
            'HttpVerbExtraction\Service\CollectionClass' => 'HttpVerbExtraction\Factory\CollectionClassFactory',
            'HttpVerbExtraction\Service\EntityClass'     => 'HttpVerbExtraction\Factory\EntityClassFactory',
        )
    ),
);
