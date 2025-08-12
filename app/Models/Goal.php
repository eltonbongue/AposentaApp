<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo',
        'valor_meta',
        'saldo_alcancado',
        'data_inicio',
        'data_fim',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
