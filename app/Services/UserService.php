<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\Career;
use App\Enums\UserType;

class UserService
{
    /**
     * @throws ValidationException
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'accountId' => $data['accountId'],
            'type' => $data['type'],
            'career' => $data['career'],
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function updateUser(User $user, array $data): User
    {
        $this->validate($data);

        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : $user->password,
            'type' => $data['type'] ?? $user->type,
            'career' => $data['career'] ?? $user->career,
        ]);

        return $user;
    }

    /**
     * @throws ValidationException
     */
    public function deleteUser(User $user): void
    {
        if ($user->type === UserType::ADMIN) {
            $user->delete();
        } else {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para eliminar este usuario.']);
        }
    }

    public function getUser(string $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @throws ValidationException
     */
    public function getUsers(): Collection
    {
        return User::all();
    }

    /**
     * @throws ValidationException
     */
    private function validate(array $data): void
    {
        $rules = [
            'email' => ['required', 'email', 'unique:users,email'],
            'type' => ['required', 'in:' . implode(',', UserType::getAllowedOptions())],
            'career' => ['required', 'in:' . implode(',', Career::getOptions())],
            'accountId' => ['required', 'unique:users,accountId'],
        ];

        validator($data, $rules)->validate();

        if ($data['type'] === UserType::ADMIN && User::where('type', UserType::ADMIN)->exists()) {
            throw ValidationException::withMessages(['type' => 'Ya existe un administrador.']);
        }
    }
}
