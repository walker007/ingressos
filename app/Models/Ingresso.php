<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingresso extends Model
{
    use HasFactory;

    protected $fillable = [
        "evento_id",
        "lote",
        "inicio",
        "fim",
        "quantidade_disponivel",
        "preco"
    ];


    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
