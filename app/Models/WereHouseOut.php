<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WereHouseOut extends Model
{
    use HasFactory;

    protected $table = 'were_house_outs';

    protected $fillable = [
        'id',
        'were_house_id',
        'quantity',
        'date',
    ];


    public function wereHouse()
    {
        return $this->belongsTo(WereHouse::class);
    }
}
