<?php

namespace App\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RouteRole
{
    public function __construct(
        public readonly string $role = 'ROLE_PLAYER'
    ) {
    }
}
