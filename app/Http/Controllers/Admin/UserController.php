<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Admin\UserRepository;
use App\Services\Admin\UserService;

class UserController extends Controller
{
    public function __construct(
        public UserRepository $userRepository,
    ){}

    public function index()
    {
        try {
            $users = User::all();
            return WebResponse::success(view('admin.users.index', compact('users')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function create()
    {
        try {
            return WebResponse::success(view('admin.users.create'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $this->userRepository->create(data: $request->all());
            return WebResponse::success(redirect()->route('users.index')->with('success', 'Новый пользователь успешно создан'));
        } catch (\Exception $e){
            return WebResponse::error($e, true);
        }
    }

    public function edit(User $user)
    {
        try {
            return WebResponse::success(view('admin.users.edit', compact('user')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->userRepository->update(data: $request->all(), user: $user);
            return WebResponse::success(redirect()->route('users.index')->with('success', 'Данные пользователя обновлены'));
        } catch (\Exception $e){
            return WebResponse::error($e, true);
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->userRepository->destroy(user: $user);
            return WebResponse::success(redirect()->route('users.index'))->with('success', 'Пользователь успешно удален');
        } catch (\Exception $e){
            return WebResponse::error($e, true);
        }
    }
}
