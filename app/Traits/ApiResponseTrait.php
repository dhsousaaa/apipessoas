<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
/**
     * Retorna uma resposta de sucesso.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $message = 'Success', $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Retorna uma resposta de erro.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message = 'Error', $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}