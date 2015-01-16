<?php
return array(
    'http-verb-extraction' => array(
        //'Name of virtual controller (checkout zfcampus/zf-rest module out)' => array(
            //'create'      => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'delete'      => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'deleteList'  => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'fetch'       => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'fetchAll'    => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'patch'       => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'patchList'   => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'replaceList' => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
            //'update'      => 'A service name registered in the main service manager, returning object of type HttpVerbExtraction\DispatchableInterface.php',
        //),
        // Repeat for each controller
    ),

    'service_manager' => array(
        'invokables' => array(
            'HttpVerbExtraction\Service\ControllerName'      => 'HttpVerbExtraction\Service\ControllerName',
            'HttpVerbExtraction\ErrorMessage\NotImplemented' => 'HttpVerbExtraction\ErrorMessage\NotImplemented',
        ),
        'factories' => array(
            'HttpVerbExtraction\Service\CollectionClass' => 'HttpVerbExtraction\Factory\CollectionClassFactory',
            'HttpVerbExtraction\Service\EntityClass'     => 'HttpVerbExtraction\Factory\EntityClassFactory',
            'HttpVerbExtraction\Service\VerbServiceName' => 'HttpVerbExtraction\Factory\VerbServiceNameFactory',
        )
    ),
    'humus_phpunit_module' => array(
        'phpunit_runner' => array(
            'HttpVerbExtraction' => [
                __DIR__ . '/../phpunit.xml.dist'
            ]
        )
    ),
);
