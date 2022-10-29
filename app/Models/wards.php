<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wards extends Model
{
    use HasFactory;
    protected $table = 'wards';

    protected $fillable = [
        'id',
        'county_no',
        'constituency_no',
        'name',
    ];
}
