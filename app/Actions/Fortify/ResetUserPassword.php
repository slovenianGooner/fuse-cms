<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Validator;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    public function reset($user, array $input): void
    {
        Validator::make($input, ['password' => $this->passwordRules()])->validate();

        $user->forceFill([
            'password' => $input['password'],
        ]);
    }
}
