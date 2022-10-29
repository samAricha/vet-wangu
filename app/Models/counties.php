<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class counties extends Model
{
    use HasFactory;
    protected $table = 'counties';

    protected $fillable = [
        'id',
        'name',
    ];
}
