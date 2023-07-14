<?php

namespace App\Console\Commands;

use App\Models\Permissao;
use App\Models\User;
use Illuminate\Console\Command;

class GerenciaUsuario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gerencia:usuario {usuarioId : Id do usuário} {--permissao=* : permissões a serem atribuidas} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerencia usuários';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usuarioId = $this->argument("usuarioId");
        $permissao = $this->option("permissao");


        $usuario = User::find($usuarioId);

        if (!$usuario) {
            $this->error("Usuário não encontrado");
            return;
        }

        $permissoes = Permissao::select("id")->whereIn('nome', $permissao)->get();

        if ($permissoes->count() > 0) {
            $usuario->permissoes()->sync($permissoes);
            $this->info("Permissões definidas com sucesso");
        }
    }
}
