<?php

namespace Services\Helpers;

use App\Models\Role;
use Database\Enums\Roles;

class RoleHelper {
    public static function getRepresentatives() {
        $repRole = Role::firstWhere('name', Roles::REPRESENTATIVE->value);
        return $repRole->users;
    }
}