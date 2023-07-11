<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Evento;
use App\Http\Requests\EventosRequest;

class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::all();

        return response()->json($eventos, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventosRequest $request)
    {
        $evento = Evento::create($request->all());

        return response()->json($evento, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json(["message" => "Nâo encontrado"], Response::HTTP_NOT_FOUND);
        }

        return response()->json($evento, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventosRequest $request, int $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json(["message" => "Nâo encontrado"], Response::HTTP_NOT_FOUND);
        }

        $evento->update($request->all());

        return response()->json($evento, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json(["message" => "Nâo encontrado"], Response::HTTP_NOT_FOUND);
        }

        $evento->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
