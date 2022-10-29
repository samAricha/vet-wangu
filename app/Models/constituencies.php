<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class constituencies extends Model
{
    use HasFactory;
    protected $table = 'constituencies';

    protected $fillable = [
        'id',
        'county',
        'name',
    ];
}
