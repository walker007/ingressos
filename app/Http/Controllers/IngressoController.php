<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngressoRequest;
use App\Http\Requests\UpdateIngressoRequest;
use App\Models\Ingresso;
use Illuminate\Http\Response;

class IngressoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingressos = Ingresso::all();
        $ingressos->load("evento");

        return response()->json($ingressos, Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngressoRequest $request)
    {
        $ingresso = Ingresso::create($request->all());

        return response()->json($ingresso, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $ingresso = Ingresso::find($id);

        if (!$ingresso) {
            return response()->json(["message" => "Lote não encontrado"], Response::HTTP_OK);
        }

        $ingresso->load('evento');

        return response()->json($ingresso, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngressoRequest $request, Ingresso $ingresso)
    {
        if (!$ingresso) {
            return response()->json(["message" => "Lote não encontrado"], Response::HTTP_OK);
        }

        $ingresso->update($request->all());

        return response()->json($ingresso, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingresso $ingresso)
    {
        if (!$ingresso) {
            return response()->json(["message" => "Lote não encontrado"], Response::HTTP_OK);
        }

        $ingresso->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
