<?php

namespace Cravelight\Security\UserAuthentication\DataAccess\Repositories;

use Carbon\Carbon;
use Cravelight\Security\UserAuthentication\DataAccess\Models\EloquentEmailAccessCredential;
use Cravelight\Security\UserAuthentication\Domain\Models\EmailAccessCredential;
use Cravelight\Security\UserAuthentication\Domain\Repositories\IEmailAccessCredentialRepository;


class EmailAccessCredentialRepository implements IEmailAccessCredentialRepository
{

    public function store(EmailAccessCredential $emailAccessCredential) : EmailAccessCredential
    {
        $model = $this->getModelFor($emailAccessCredential);
        $model->updated_at = new Carbon();
        $model->save();
        return $this->fetchForEmailAddress($emailAccessCredential->email);
    }

    public function fetchForEmailAddress(string $emailAddress) : EmailAccessCredential
    {
        $model = EloquentEmailAccessCredential::find($emailAddress);
        return is_null($model)
            ? null
            : $this->getPopoFor($model);
    }



    private function getModelFor(EmailAccessCredential $popo) : EloquentEmailAccessCredential
    {
        $model = EloquentEmailAccessCredential::find($popo->email);
        if (is_null($model)) {
            $model = new EloquentEmailAccessCredential();
            $model->email = $popo->email;
            $model->created_at = new Carbon();
        }
        $model->password_hash = $popo->passwordHash;
        $model->verified_at = $popo->verifiedAt;
        // Dont let the popo set timestamps
        // $model->created_at = $popo->createdAt;
        // $model->updated_at = $popo->updatedAt;
        return $model;
    }

    private function getPopoFor(EloquentEmailAccessCredential $model) : EmailAccessCredential
    {
        $popo = new EmailAccessCredential($model->email);
        $popo->passwordHash = $model->password_hash;
        $popo->verifiedAt = $model->verified_at;
        $popo->createdAt = $model->created_at;
        $popo->updatedAt = $model->updated_at;
        return $popo;
    }

}
