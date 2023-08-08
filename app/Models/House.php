<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $table = 'houses';
    protected  $fillable =[
        'housenumber',
        'owner',
        'email',
        'phone',
        'fee',
        'water_unit_price',
        'electric_unit_price',
    ];
}
