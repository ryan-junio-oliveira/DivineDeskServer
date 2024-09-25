<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WereHouse extends Model
{
    use HasFactory;

    protected $table = 'were_houses';

    protected $fillable =
    [
        'id',
        'name',
        'quantity',
        'date'
    ];

    public function wereHouseOut()
    {
        return $this->hasMany(WereHouseOut::class);
    }

}
