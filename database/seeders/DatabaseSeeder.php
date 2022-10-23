<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Address;
use App\Models\Company;
use App\Models\Customer;
use Database\Enums\Roles;
use Database\Enums\States;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Services\Helpers\TimeHelper;
use App\Models\FirstLevelDivision;
use Database\Seeders\CompanySeeder;
use Database\Enums\FirstLevelDivisions;
use Database\Seeders\FirstLevelDivisionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
          RoleSeeder::class,
          CompanySeeder::class
        ]);

        $adminRole = Role::firstWhere('name', Roles::ADMIN->value);
        $repRole = Role::firstWhere('name', Roles::REPRESENTATIVE->value);
        $companies = Company::all();
        $states = States::cases();

        User::factory()->for($adminRole)->create(['email' => 'test@test.com']);
        User::factory()
          ->count(8)
          ->for($repRole)
          ->create();

        $reps = $repRole->users;

        Customer::factory()
            ->count(50)
            ->sequence(function ($sequence) use ($states, $companies) {
                $state = $states[array_rand($states)];
                return [
                    'state' => $state->value,
                    'first_level_division' => $state->firstLevelDivision()->value,
                    'company_id' => $companies->random()
                ];
            })
            ->create();

        $customers = Customer::all();
        $th = TimeHelper::get();
        $start = Carbon::now()->startOfDay()->setHour(9)->subDays(90);

        Appointment::factory()
            ->count(140)
            ->sequence(function($s) use ($reps, $customers, $start) {
                $index = $s->index;
                $startTimeOffset = rand(1, 4);
                $endTimeOffset = rand(1, 3);
                $startDate = $start->copy();

                $startDate->addDays($index);
                $startDate->addHours($startTimeOffset);

                if($startDate->isWeekend()) {
                    $startDate->addDays(2);
                }
                
                $endDate = $startDate->copy();
                $endDate->addHours($endTimeOffset);

                return [
                    'user_id' => $reps->random(),
                    'customer_id' => $reps->random(),
                    'start' => $startDate,
                    'end' => $endDate
                ];
            })
            ->create();
    }
}
