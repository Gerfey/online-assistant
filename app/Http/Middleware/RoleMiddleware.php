<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Closure;

class RoleMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $roles = collect(explode('|', $role))
            ->map(function($roleCode) {
                if (empty($roleCode)) {
                    return false;
                }
                return Role::query()
                    ->where('code', $roleCode)
                    ->first();
            })->filter(function ($role) {
                return $role instanceof Role;
            })->map->id->all();

        foreach ($roles as $roleId) {
            if (Auth::user()->hasRole($roleId)) {
                return $next($request);
            }
        }
        return redirect()->back();
    }
}
