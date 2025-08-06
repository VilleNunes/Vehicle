<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marca = $this->marca->all();
        return ['dados' => $marca];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => ['required', 'unique:marcas'],
            'imagem' => ['required'],
        ]);

        $dados = $request->all();
        $marca = $this->marca->create($dados);

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $marca = $this->marca->find($id);

        if (!$marca) {
            return response()->json(['message' => 'Marca não encontrada!!'], 404);
        }

        return $marca;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $dados = $request->validate([
            'nome' => ['required', Rule::unique('marcas')->ignore($id)],
        ]);

        $marca = $this->marca->find($id);

        if (!$marca) {
            return response()->json(['message' => 'Marca não encontrada!!'], 404);
        }

        if ($request->filled('imagem')) {
            $dados['imagem'] = $request->get('imagem');
        }

        $marca->update($dados);

        return response()->json($marca);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $marca = $this->marca->find($id);

        if (!$marca) {
            return response()->json(['message' => 'Marca não encontrada!!'], 404);
        }

        $marca->destroy();

        return [];
    }
}
