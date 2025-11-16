<?php

namespace App\Enum;

enum Modal: string
{
    case CREATE_USER = 'create-user';
    case EDIT_USER = 'edit-user';
    case DELETE_USER = 'delete-user';
}
