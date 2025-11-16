<?php

namespace App\Enum;

use Illuminate\Support\Str;

enum Role: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';

    public function getLabel(): string
    {
        return Str::title($this->value);
    }
}
