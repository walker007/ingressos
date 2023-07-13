<?php

namespace App\Console\Commands;

use App\Models\Permissao;
use Illuminate\Console\Command;

class GerenciaPermissao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gerencia:permissao {permissaoNome : Nome da Permissao} {--apagar : Apaga a permissao}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria ou apaga uma Permissão no sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissaoNome = $this->argument("permissaoNome");
        $apagar = $this->option("apagar");

        $permissao = Permissao::where("nome", $permissaoNome)->first();

        if ($apagar) {

            if (!$permissao) {
                $this->error("Permissão não encontrada");
                return;
            }

            $permissao->delete();
            $this->info("Permissão apagada com sucesso");
            return;
        }

        if ($permissao) {
            $this->error("Permissão {$permissao->nome} já existe e não será criada novamente");
            return;
        }

        Permissao::create(["nome" => $permissaoNome]);
        $this->info("Permissão {$permissaoNome} criada com sucesso");
    }
}
