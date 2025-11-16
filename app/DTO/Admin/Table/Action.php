<?php

namespace App\DTO\Admin\Table;

class Action
{
    public function __construct(
        public string  $method,
        public string  $label,
        public ?string $icon = null,
    )
    {

    }
}
