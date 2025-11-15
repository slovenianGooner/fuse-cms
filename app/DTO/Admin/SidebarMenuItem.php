<?php

namespace App\DTO\Admin;

class SidebarMenuItem
{
    public function __construct(
        public string  $name,
        public string  $label,
        public string  $url,
        public ?string $icon = null,
        public ?bool   $active = null,
    )
    {

    }
}
