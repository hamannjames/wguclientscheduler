<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Company;
use App\Models\Appointment;
use App\Models\FirstLevelDivision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function fullName() {
        return $this->first_name . " " . $this->last_name;
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function toString() {
        return $this->fullName();
    }
}
