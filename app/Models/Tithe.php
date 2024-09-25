<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tithe extends Model
{
    use HasFactory;

    protected $table = 'tithe';

    protected $fillable = [
        'id',
        'user_id',
        'member_id',
        'value',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {

        return $this->belongsTo(Member::class);

    }
}
