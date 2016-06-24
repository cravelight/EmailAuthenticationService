<?php

namespace Cravelight\Security\UserAuthentication\Domain\Repositories;

use Cravelight\Security\UserAuthentication\Domain\Models\EmailVerificationToken;


interface IEmailVerificationTokenRepository
{
    public function store(EmailVerificationToken $emailVerificationToken) : EmailVerificationToken;

    public function fetch(string $email, string $token) : EmailVerificationToken;

}