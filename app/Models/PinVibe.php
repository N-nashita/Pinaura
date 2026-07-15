<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinVibe extends Model
{
    protected $fillable = ['user_id', 'pin_id'];

    public function pin()
    {
        return $this->belongsTo(Pin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}