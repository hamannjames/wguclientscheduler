<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstLevelDivision extends Model
{
    use HasFactory;

    public function toString() {
        return $this->name;
    }
}
