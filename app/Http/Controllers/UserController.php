<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Database\Enums\Roles;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $role = Role::where('name', Roles::REPRESENTATIVE->value)->first();
        $reps = $role->users;

        return view('user.index', ['reps' => $reps]);
    }

    public function show(User $user) {
        return view('user.show', ['rep' => $user]);
    }
}
