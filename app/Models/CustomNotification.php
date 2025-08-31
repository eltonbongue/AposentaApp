<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomNotification extends Model
{
    protected $fillable = [
        'user_id',
        'mensagem',
        'lida',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
