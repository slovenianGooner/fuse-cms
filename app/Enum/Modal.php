<?php

namespace App\Enum;

enum Modal: string
{
    case CONFIRM = 'confirm';

    case CREATE_USER = 'create-user';
    case EDIT_USER = 'edit-user';
}
