<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard() {
        $divisionAppointmentsAll = DB::table('appointments')
            ->selectRaw('first_level_division, count(*) as numAppointments')
            ->join('customers', 'appointments.customer_id', '=', 'customers.id')
            ->groupBy('first_level_division')
            ->get();

        $divisionAppointmentsFuture = DB::table('appointments')
            ->selectRaw('first_level_division, count(*) as numAppointments')
            ->join('customers', 'appointments.customer_id', '=', 'customers.id')
            ->where('start', '>' , Carbon::now() -> startOfDay())
            ->groupBy('first_level_division')
            ->get();

        $customerMaxAll = DB::table('appointments')
            ->selectRaw('first_name, last_name, email, count(*) as numAppointments')
            ->join('customers', 'appointments.customer_id', '=', 'customers.id')
            ->groupBy('first_name', 'last_name', 'email')
            ->orderBy('numAppointments', 'desc')
            ->get();

        $customerMaxFuture = DB::table('appointments')
            ->selectRaw('first_name, last_name, email, count(*) as numAppointments')
            ->join('customers', 'appointments.customer_id', '=', 'customers.id')
            ->where('start', '>' , Carbon::now() -> startOfDay())
            ->groupBy('first_name', 'last_name', 'email')
            ->orderBy('numAppointments', 'desc')
            ->get();

        $repMaxAll = DB::table('appointments')
            ->selectRaw('name, email, count(*) as numAppointments')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->groupBy('email')
            ->orderBy('numAppointments', 'desc')
            ->get();

        $repMaxFuture = DB::table('appointments')
            ->selectRaw('name, email, count(*) as numAppointments')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->where('start', '>' , Carbon::now() -> startOfDay())
            ->groupBy('email')
            ->orderBy('numAppointments', 'desc')
            ->get();

        return view('dashboard', [
            'divisionAll' => $divisionAppointmentsAll,
            'divisionFiltered' => $divisionAppointmentsFuture,
            'customerAll' => $customerMaxAll,
            'customerFiltered' => $customerMaxFuture,
            'repAll' => $repMaxAll,
            'repFiltered' => $repMaxFuture
        ]);
    }
}
