<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question',
        'response',
        'category',
    ];

    // Relacionamento opcional com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
