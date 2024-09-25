<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'id',
        'name',
        'last_name',
        'address',
        'tel',
        'email',
        'marital_status',
    ];

    public function tithe()
    {
        return $this->hasMany(Tithe::class);
    }

}
