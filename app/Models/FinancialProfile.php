<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salario_actual',
        'poupanca',
        'investimentos',
        'montante_aposentadoria',
        'idade_aposentadoria',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
