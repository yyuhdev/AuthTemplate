<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'text',
        'pos_x',
        'pos_y',
        'width',
        'height',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
