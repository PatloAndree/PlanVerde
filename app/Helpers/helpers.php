<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('role_route')) {
    function role_route($routeName, $parameters = []) {
        $role = Auth::user()->getRoleNames()->first(); // Obtener el rol del usuario
        return route($role . '.' . $routeName, $parameters);
    }
}
