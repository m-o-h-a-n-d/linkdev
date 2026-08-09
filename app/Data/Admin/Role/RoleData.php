<?php

namespace App\Data\Admin\Role;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class RoleData extends Data
{
    public function __construct(
        #[Required]
        public string $name,

        #[ArrayType]
        public array $permissions = [],
    ) {}
}
