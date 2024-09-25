<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertUser extends Model
{
    use HasFactory;

    protected $table = 'alert_user';

    protected $fillable = [
        'id',
        'alert_id',
        'user_id',
    ];

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}


