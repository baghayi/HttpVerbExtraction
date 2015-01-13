<?php
namespace HttpVerbExtraction\Test\Traits;

class IdentityTest extends \PHPUnit_Framework_TestCase {

    public function test_if_returnes_identity_object()
    {
        $identityInterface = 'ZF\MvcAuth\Identity\IdentityInterface';
        $identityMock = $this->getMock($identityInterface);

        $resourceEvent = $this->getMock('ZF\Rest\ResourceEvent');
        $resourceEvent->method('getIdentity')
            ->willReturn($identityMock);

        $identity = $this->getObjectForTrait('HttpVerbExtraction\Traits\Identity');
        
        $returnedIdentity = $identity->getIdentity($resourceEvent);
        $this->assertInstanceOf($identityInterface, $returnedIdentity);
    }

}
