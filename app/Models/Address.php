<?php

namespace App\Models;

use App\Models\FirstLevelDivision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    public function firstLevelDivision() {
        return $this->belongsTo(FirstLevelDivision::class);
    }
}
