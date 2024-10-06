<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtSlot extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const REMOVE = 2;
}
