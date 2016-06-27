<?php

use Cravelight\PhpUnit\Database_TestCase;
use Cravelight\Security\UserAuthentication\DataAccess\Repositories\EmailAccessCredentialRepository;
use Cravelight\Security\UserAuthentication\DataAccess\Repositories\EmailVerificationTokenRepository;
use Cravelight\Security\UserAuthentication\Domain\Models\EmailAccessCredential;
use Cravelight\Security\UserAuthentication\Domain\Models\EmailVerificationToken;
use Cravelight\Security\UserAuthentication\EmailAuthenticationService;
use \Mockery as m;


class EmailAuthenticationServiceTest extends Database_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }


//    User clicks register
//    User enters email address (required)
//    System creates unverified user account
    public function testRegisterUniqueEmailAddress()
    {
        // Arrange|Given
        $emailAuthenticationService = new EmailAuthenticationService(new EmailAccessCredentialRepository(), new EmailVerificationTokenRepository());
        $email = 'test_' . uniqid() . '@address.com';

        // Act|When
        $accessCreds = $emailAuthenticationService->registerEmailAddress($email);


        // Assert|Then
        $this->assertEquals($email, $accessCreds->email);
        $this->assertNull($accessCreds->passwordHash);
        $this->assertNull($accessCreds->verifiedAt);
        $this->assertNotNull($accessCreds->createdAt);
        $this->assertEquals($accessCreds->createdAt->getTimestamp(), time(), '', 5);
        $this->assertNotNull($accessCreds->updatedAt);
        $this->assertEquals($accessCreds->updatedAt->getTimestamp(), time(), '', 5);
    }

    public function testRegisterDuplicateEmailAddress()
    {
        // Arrange|Given
        $emailAuthenticationService = new EmailAuthenticationService(new EmailAccessCredentialRepository(), new EmailVerificationTokenRepository());
        $email = 'test_hard_coded@address.com';

        // Act|When
        $emailAuthenticationService->registerEmailAddress($email); // register it once
        $accessCreds = $emailAuthenticationService->registerEmailAddress($email); // register it again


        // Assert|Then
        $this->assertEquals($email, $accessCreds->email);
        $this->assertNull($accessCreds->passwordHash);
        $this->assertNull($accessCreds->verifiedAt);
        $this->assertNotNull($accessCreds->createdAt);
        $this->assertNotNull($accessCreds->updatedAt);
        $this->assertEquals($accessCreds->updatedAt->getTimestamp(), time(), '', 5);
    }

}
