<?php

use App\Models\Navigation;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        $user = Auth::user();

        // Cek permission user
        $userPermissions = $user->getAllPermissions()->pluck('name');

        // Ambil menu utama
        $menus = Navigation::whereNull('main_menu')
            ->whereHas('permissions', function ($query) use ($userPermissions) {
                $query->whereIn('name', $userPermissions);
            })
            ->with(['subMenus' => function ($query) use ($userPermissions) {
                $query->whereHas('permissions', function ($subQuery) use ($userPermissions) {
                    $subQuery->whereIn('name', $userPermissions);
                });
            }])
            ->orderBy('sort', 'asc')
            ->get();

        // Return menus collection
        return $menus;
    }
}
