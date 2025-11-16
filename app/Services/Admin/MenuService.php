<?php

namespace App\Services\Admin;

use App\DTO\Admin\SidebarMenuGroup;
use App\DTO\Admin\SidebarMenuItem;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class MenuService
{
    public static function getMenu()
    {
        $user = auth()->user();

        $items = [
            new SidebarMenuItem('Dashboard', 'Dashboard', route('admin.dashboard'), 'home'),
        ];

        if ($systemMenu = self::getSystemMenu(auth()->user()) and count($systemMenu)) {
            $items[] = new SidebarMenuGroup('system', 'System', true, $systemMenu, icon: 'cog');
        }

        return $items;
    }

    public static function getSystemMenu(User $user): array
    {
        $items = [];

        if ($user->can('view-any', User::class)) {
            $items[] = new SidebarMenuItem('Users', 'Users', route('admin.system.users.index'), 'users');
        }

        return $items;
    }
}
