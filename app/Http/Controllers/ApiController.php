<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaStoreRequest;
use Exception;
use App\Models\User;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UsuarioTokenRequest;
use App\Http\Requests\UsuarioRegisterRequest;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{

    use ApiResponseTrait;
    
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
     * Registrar um usuário para usar API
     */
    public function register(UsuarioRegisterRequest $request)
    {   
        try {
            $payload = $request->all();
            $payload['password'] = Hash::make($payload['password']);
            $usuario = User::create($request->all());
    
    
            return $this->success(
                $usuario,
                'Usuário criado com sucesso.',
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return $this->error(
                "Erro para criar usuário, motivo: {$th->getMessage()}",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * Criar um novo token para pode realizar request
     */
    public function token(UsuarioTokenRequest $request)
    {
        try {
            $payload = $request->all();
            if (!Auth::attempt($payload)) {
                throw new Exception('Credencias não encontradas.', Response::HTTP_UNAUTHORIZED);
            }

            $user = auth()->user();

            return $this->success(
                [
                    'token' => $user->createToken('API Token')->plainTextToken,
                    'user' => $user
                ],
                'Token criado com sucesso.',
                Response::HTTP_CREATED
            );
            
        } catch (\Throwable $th) {
            return $this->error(
                "Erro para criar token, motivo: {$th->getMessage()}",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PessoaStoreRequest $request)
    {
        try {
            $payload = $request->all();
            $payload['usuario_id'] = auth()->user()->id;

            // Criação da pessoa
            $pessoa = Pessoa::create($payload);

            // Resposta de sucesso (pode ser personalizada conforme necessário)
            return $this->success(
                $pessoa,
                'Pessoa criada com sucesso',
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
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
            return $this->success($pessoa);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
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
                return $this->error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $pessoa = Pessoa::find($id);

            if (!$pessoa) {
                throw new Exception('Pessoa não encontrada.', Response::HTTP_NOT_FOUND);
            }

            $pessoa->update($campos);
            return $this->success(
                $pessoa,
                'Pessoa atualizada com sucesso'
            );
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
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
            return $this->success([], 'Pessoa deletada com sucesso');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }
}
