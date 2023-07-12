<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
        "descricao",
        "local",
        "data_evento",
        "user_id",
        "slug"
    ];

    protected $casts = [
        "data_evento" => "datetime"
    ];

    protected $hidden = [
        "user_id",
        "created_at",
        "updated_at"
    ];

    public function ingressos()
    {
        return $this->hasMany(Ingresso::class);
    }
}
