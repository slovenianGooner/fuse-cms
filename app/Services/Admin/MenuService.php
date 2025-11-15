<?php

namespace App\Services\Admin;

use App\DTO\Admin\SidebarMenuItem;

class MenuService
{
    public static function getMenu()
    {
        $user = auth()->user();

        $items = [
            new SidebarMenuItem('Dashboard', 'Dashboard', route('admin.dashboard'), 'home'),
        ];

        return $items;
    }
}
