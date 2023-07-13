<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $table = "permissoes";

    protected $fillable = [
        "nome"
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "permissoes_user");
    }
}
