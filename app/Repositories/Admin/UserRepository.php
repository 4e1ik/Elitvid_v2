<?php

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function update(array $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            if (empty($data['password'])) {
                unset($data['password']);
            }

            throw_if($data['role'] === 'admin', new \Exception('Нельзя создать еще одного пользователя с ролью admin'));
            $user->update($data);
        });
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            throw_if($data['role'] === 'admin', new \Exception('Нельзя создать еще одного пользователя с ролью admin'));
            User::create($data);
        });
    }

    public function destroy(User $user)
    {
        return DB::transaction(function () use ($user) {
            throw_if(auth()->id() === $user->id, new \Exception('Нельзя удалить самого себя'));
            $user->delete();
        });
    }
}
