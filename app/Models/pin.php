<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pin extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'category',
        'vibe_tag',
        'is_public',
        'vibe_count',
    ];
 
    protected $casts = [
        'is_public' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function boards()
    {
        return $this->belongsToMany(Board::class);
    }
 
    public function vibes()
    {
        return $this->hasMany(PinVibe::class);
    }
}
