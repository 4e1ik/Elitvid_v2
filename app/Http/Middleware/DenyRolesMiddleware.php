<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DenyRolesMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $deniedRoles = array_filter(explode(',', implode(',', $roles)));
        $currentRole = Auth::user()?->role;
        $currentRoleValue = $currentRole instanceof UserRole ? $currentRole->value : $currentRole;

        if (in_array($currentRoleValue, $deniedRoles, true)) {
            return redirect()->back()->with('error', 'Для вашего аккаунта это действие недоступно.');
        }

        return $next($request);
    }
}
