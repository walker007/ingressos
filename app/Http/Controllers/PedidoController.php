<?php

namespace App\Http\Controllers;

use App\Enums\PedidoStatus;
use App\Http\Requests\PedidoRequest;
use App\Models\Ingresso;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\Model;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Event;
use Stripe\StripeClient;
use Stripe\Webhook;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function store(PedidoRequest $request)
    {
        $ingressos = $request->all()['ingressos'];
        $user =  Auth::user();
        $valorTotal = 0;

        $pedido = $user->pedidos()->create([
            "valor_total" => $valorTotal,
            "status" => PedidoStatus::getName(PedidoStatus::PENDENTE),
        ]);

        foreach ($ingressos as $ingresso) {
            $ingressoData = Ingresso::find($ingresso['id']);
            $quantidade = $ingresso['quantidade'];
            $valorTotal += $ingressoData->preco * $quantidade;

            $pedido->ingressos()->attach($ingressoData, ["quantidade" => $quantidade]);

            $ingressoData->quantidade_disponivel -= $quantidade;
            $ingressoData->save();
        }

        $pedido->valor_total = $valorTotal;
        $pedido->save();
        $pedido->load("ingressos");
        return response()->json($pedido, Response::HTTP_CREATED);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $pedidos = $user->pedidos()->paginate();

        return response()->json($pedidos, Response::HTTP_OK);
    }

    public function checkout(int $id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->status == PedidoStatus::getName(PedidoStatus::PAGO)) {
            return response()->json(["message" => "Pedido já foi pago"], Response::HTTP_BAD_REQUEST);
        }


        $pedido->load("ingressos");

        $lineItems = $pedido->ingressos->map(function (Ingresso $ingresso) {
            $quantidade = $ingresso->pivot->quantidade;
            $preco = $ingresso->preco;
            $nome = "Ingresso Lote: " . $ingresso->lote;

            return [
                "quantity"          => $quantidade,
                'price_data'        => [
                    "currency"      => "BRL",
                    "unit_amount"   => $preco * 100,
                    "product_data"  => [
                        'name'      => $nome
                    ]
                ]
            ];
        })->toArray();

        array_push($lineItems, [
            "quantity"          => 1,
            'price_data'        => [
                "currency"      => "BRL",
                "unit_amount"   => 7.5 * 100,
                "product_data"  => [
                    'name'      => "Frete / Taxa de entrega"
                ]
            ]
        ]);

        Stripe::setApiKey(env("STRIPE_PRIVATE_KEY"));
        Stripe::setApiVersion('2020-08-27');

        $stripePedido = Session::create([
            "mode" => "payment",
            'success_url' => route('pagamento.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('pagamento.error'),
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            "metadata" => [
                "pedido_id" => $pedido->id
            ],
        ]);

        $pedido->payment_intent_id = $stripePedido->payment_intent;
        $pedido->status = PedidoStatus::getName(PedidoStatus::EM_PROCESSAMENTO);
        $pedido->save();

        return response()->json(["payment_url" =>  $stripePedido->url, "pedido" => $pedido], Response::HTTP_OK);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env("STRIPE_PRIVATE_KEY"));
        Stripe::setApiVersion('2020-08-27');
        $session = Session::retrieve($request->get("session_id"));
        $pedido = Pedido::where("payment_intent_id", $session->payment_intent)->first();
        return response()->json($pedido, Response::HTTP_OK);
    }

    public function error()
    {
        return "Não Processado";
    }

    public function webhook(Request $request)
    {
        Stripe::setApiKey(env("STRIPE_PRIVATE_KEY"));
        $endpointSecret = "whsec_e06bd1e5b157802e32120107ca872703ee129e6661130f6e01ee0bb6f4cf1dc9";
        $event = Event::constructFrom($request->all());

        switch ($event->type) {
            case "payment_intent.succeeded":
                $pedido = Pedido::where("payment_intent_id", $event->data->object->id)->first();

                if (!$pedido) {
                    return response()->json(['msg' => "Pedido não encontrado"]);
                }

                $pedido->status = PedidoStatus::getName(PedidoStatus::PAGO);
                $pedido->save();
                return response()->json(['msg' => "Pedido Atualizado com sucesso"]);

                break;
            default:
                return response()->json(['msg' => "Evento {$event->type} não está classificado"]);
        }
    }
}
