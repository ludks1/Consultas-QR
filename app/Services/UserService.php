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
        if ($data['type'] !== UserType::ADMIN && User::where('type', UserType::ADMIN)->exists()) {
            throw ValidationException::withMessages(['type' => 'Ya existe un administrador.']);
        }
        $this->validate($data);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'accountId' => $data['accountId'],
            'career' => $data['career'],
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function updateUser(User $user, array $data): User
    {
        $this->validate($data);
        if ($user['type'] === UserType::ADMIN) {
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => $data['type'],
                'accountId' => $data['accountId'],
                'career' => $data['career'],
            ]);
            return $user;
        } elseif ($user['type'] === UserType::STUDENT || $user['type'] === UserType::TEACHER) {
            $user->update([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            return $user;
        } else {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para modificar un usuario.']);
        }
    }

    /**
     * @throws ValidationException
     */
    public function deleteUser(User $user): void
    {
        if ($user['type'] === UserType::ADMIN) {
            $user->delete();
        } else {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para eliminar un usuario.']);
        }
    }

    public function getUser(string $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @throws ValidationException
     */
    public function getUsers(User $user): Collection
    {
        if ($user['type'] === UserType::ADMIN) {
            return User::all();
        } else {
            throw ValidationException::withMessages(['type' => 'No cuentas con los permisos para ver los usuarios.']);
        }
    }

    /**
     * @throws ValidationException
     */
    private function validate(array $data): void
    {
        if (User::where('email', $data['email'])->exists()) {
            throw ValidationException::withMessages(['email' => 'El correo electrónico ya está en uso.']);
        }
        if ($data['type'] === UserType::ADMIN && User::where('type', UserType::ADMIN)->exists()) {
            throw ValidationException::withMessages(['type' => 'Ya existe un administrador.']);
        }
        if (!UserType::tryFrom($data['type'])) {
            throw ValidationException::withMessages(['type' => 'Tipo de usuario inválido.']);
        }
        if (!Career::tryFrom($data['career'])) {
            throw ValidationException::withMessages(['career' => 'Carrera inválida.']);
        }
        if (User::where('accountId', $data['accountId'])->exists()) {
            throw ValidationException::withMessages(['accountId' => 'La cuenta ya está en uso.']);
        }
    }
}
