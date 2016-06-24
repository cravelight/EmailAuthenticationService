<?php

namespace Cravelight\Security\UserAuthentication\Domain\Repositories;

use Cravelight\Security\UserAuthentication\Domain\Models\EmailAccessCredential;


interface IEmailAccessCredentialRepository
{
    public function store(EmailAccessCredential $emailAccessCredential) : EmailAccessCredential;

    public function fetchForEmailAddress(string $emailAddress) : EmailAccessCredential;

}
