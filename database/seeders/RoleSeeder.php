<?php

namespace Database\Seeders;

use Database\Enums\Roles;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $roles = array_column(Roles::cases(), 'value');

      Role::factory()
        ->count(count($roles))
        ->state(new Sequence(
          fn ($sequence) => ['name' => $roles[$sequence->index]]
        ))
        ->create();
    }
}
