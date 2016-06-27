<?php

namespace Cravelight\Security\UserAuthentication\DataAccess\Repositories;

use Carbon\Carbon;
use Cravelight\Security\UserAuthentication\DataAccess\Models\EloquentEmailVerificationToken;
use Cravelight\Security\UserAuthentication\Domain\Models\EmailVerificationToken;
use Cravelight\Security\UserAuthentication\Domain\Repositories\IEmailVerificationTokenRepository;


class EmailVerificationTokenRepository implements IEmailVerificationTokenRepository
{

    public function store(EmailVerificationToken $emailVerificationToken) : EmailVerificationToken
    {
        $model = $this->getModelFor($emailVerificationToken);
        $model->save();
        return $this->fetch($emailVerificationToken->email, $emailVerificationToken->token);
    }

    public function fetch(string $email, string $token) : EmailVerificationToken
    {
        $model = EloquentEmailVerificationToken::where('email', $email)->where('token', $token)->first();
        return is_null($model)
            ? null
            : $this->getPopoFor($model);
    }



    private function getModelFor(EmailVerificationToken $popo) : EloquentEmailVerificationToken
    {
        $model = EloquentEmailVerificationToken::find($popo->token);
        if (is_null($model)) {
            $model = new EloquentEmailVerificationToken();
            $model->token = $popo->token;
            $model->created_at = new Carbon();
        }
        $model->email = $popo->email;
        $model->expires_at = $popo->expiresAt;
        // Dont let the popo set timestamps
        // $model->created_at = $popo->createdAt;
        return $model;
    }

    private function getPopoFor(EloquentEmailVerificationToken $model) : EmailVerificationToken
    {
        $popo = new EmailVerificationToken($model->email);
        $popo->token = $model->token;
        $popo->expiresAt = $model->expires_at;
        $popo->createdAt = $model->created_at;
        return $popo;
    }



}
