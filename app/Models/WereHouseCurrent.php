<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WereHouseCurrent extends Model
{
    use HasFactory;

    protected $table = 'were_house_current';

    protected $fillable = [
        'id',
        'were_house_id',
        'quantity',
    ];
}
