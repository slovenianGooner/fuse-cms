<?php

use App\Enum\Permission;
use App\Enum\Role;

return [
    'super_admin' => [
        'name' => env('FUSE_SUPER_ADMIN_NAME', 'Super Admin'),
        'email' => env('FUSE_SUPER_ADMIN_EMAIL'),
        'password' => env('FUSE_SUPER_ADMIN_PASSWORD'),
    ],

    'permissions' => [
        Role::ADMIN->value => [
            Permission::IMPERSONATE,
        ],
        Role::EDITOR->value => [

        ],
    ],
];
