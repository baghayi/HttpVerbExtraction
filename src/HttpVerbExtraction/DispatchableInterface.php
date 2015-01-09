<?php
namespace HttpVerbExtraction;

interface DispatchableInterface {

    public function dispatch(ResourceEvent $event);

}
