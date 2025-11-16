<?php

namespace App\Enum;

enum Permission: string
{
    case IMPERSONATE = 'impersonate';

    case VIEW_USERS = 'view-users';
    case CREATE_USER = 'create-user';
    case EDIT_USER = 'edit-user';
    case DELETE_USER = 'delete-user';

}
