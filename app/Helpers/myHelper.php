<?php

use App\Models\Navigation;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        // Mengambil main menu yang tidak punya parent (main_menu == null)
        return Navigation::whereNull('main_menu')->with('subMenus')->orderBy('sort', 'asc')->get();
    }
}