<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'nombreUsuario' => ['required', 'string', 'max:50', 'unique:users,nombreUsuario'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'numero' => ['required', 'string', 'max:50'],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'nombreUsuario' => $input['nombreUsuario'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'numero' => $input['numero'],
        ]);
    }
}
