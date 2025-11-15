<?php

namespace App\DTO\Admin;

class SidebarMenuGroup
{
    public function __construct(
        public string  $name,
        public string  $heading,
        public bool    $expanded = false,
        public array   $items = [],
        public ?string $icon = null,
    )
    {

    }
}
