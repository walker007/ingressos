<?php

namespace App\Enums;

enum PedidoStatus
{
    case PENDENTE;
    case EM_PROCESSAMENTO;
    case RECUSADO;
    case CANCELADO;
    case PAGO;


    public static function getName(PedidoStatus $status): string
    {
        return match ($status) {
            PedidoStatus::PENDENTE           => "Pendente",
            PedidoStatus::EM_PROCESSAMENTO   => "Em Processamento",
            PedidoStatus::RECUSADO           => "Recusado",
            PedidoStatus::CANCELADO          => "Cancelado",
            PedidoStatus::PAGO               => "Pago",
        };
    }
}
