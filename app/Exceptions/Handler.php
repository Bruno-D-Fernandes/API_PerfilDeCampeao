<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException; // 👈 Importante: Importa a exceção de autenticação

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // =========================================================================
    // 💡 MÉTODO ADICIONADO PARA FORÇAR RESPOSTA JSON EM FALHAS DE AUTENTICAÇÃO
    // =========================================================================

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Se a requisição está vindo de uma rota de API ('api/*') 
        // OU se o cliente solicitou explicitamente JSON (Accept: application/json)
        if ($request->expectsJson() || $request->is('api/*')) {
            // Retorna 401 Unauthorized com o corpo em JSON
            return response()->json([
                'message' => $exception->getMessage() ?: 'Não autenticado. O token de acesso é inválido ou está ausente.',
                'error' => 'unauthenticated'
            ], 401);
        }

        // Comportamento padrão: redirecionar para a rota de login do navegador
        return redirect()->guest(route('login')); 
        
        // Se você não tem uma rota nomeada 'login', use: return redirect()->guest('/login');
    }
}