<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'race',
        'size',
        'favorite_color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
