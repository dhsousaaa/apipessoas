<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            ['message' => 'sucesso']
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $request->validate([
                'nome' => 'required|string',
                'sobrenome' => 'required|string',
                'email' => 'required|email|unique:pessoas,email',
                'data_nascimento' => 'required|date_format:Y-m-d',
                'endereco' => 'required|string',
                'telefone' => 'required|string',
            ]);

            // Criação da pessoa
            $pessoa = Pessoa::create($request->all());

            // Resposta de sucesso (pode ser personalizada conforme necessário)
            return response()->json(
                [
                    'message' => 'Pessoa criada com sucesso',
                    'data' => $pessoa
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pessoa = Pessoa::find($id);

            if (!$pessoa) {
                throw new Exception('Pessoa não encontrada.', Response::HTTP_NOT_FOUND);
            }
            return response()->json(['data' => $pessoa]);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validação dos dados
            $rules = [];
            $campos = $request->all();
            
            foreach ($campos as $campo => $valor) {
                $rules[$campo] = $campo === 'email' ? 'required|email|unique:pessoas,email,' . $id : 'required';
            }

            $validator = Validator::make($campos, $rules);

            // Verifica se a validação falhou
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $pessoa = Pessoa::find($id);

            if (!$pessoa) {
                throw new Exception('Pessoa não encontrada.', Response::HTTP_NOT_FOUND);
            }

            $pessoa->update($campos);
            return response()->json(
                [
                    'message' => 'Pessoa atualizada com sucesso',
                    'data' => $pessoa
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pessoa = Pessoa::destroy($id);

            if (!$pessoa) {
                throw new Exception('Pessoa não encontrada.', Response::HTTP_NOT_FOUND);
            }
            return response()->json(['message' => 'Pessoa deletada com sucesso']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
