<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetClubGuardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Este middleware automaticamente define o guard correto para clubes
     * permitindo que Auth::user() funcione sem modificar controllers
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se a requisição é para rotas de clube
        if ($this->isClubRoute($request)) {
            // Define o guard padrão como 'club_sanctum' para esta requisição
            Auth::shouldUse('club_sanctum');
        }

        return $next($request);
    }

    /**
     * Determina se a rota atual é uma rota de clube
     */
    private function isClubRoute(Request $request): bool
    {
        $path = $request->path();
        
        // Lista de padrões que indicam rotas de clube
        $clubPatterns = [
            'api/clube/',
            'perfil',
            'pesquisa',
            'dashboard',
            'oportunidades',
            'listas',
            'mensagens',
            'notificacoes',
            'configuracoes'
        ];

        // Verifica se a URL atual corresponde a algum padrão de clube
        foreach ($clubPatterns as $pattern) {
            if (str_contains($path, $pattern)) {
                return true;
            }
        }

        // Verifica se há um token de clube no header Authorization
        $authHeader = $request->header('Authorization');
        if ($authHeader && $this->isClubToken($authHeader)) {
            return true;
        }

        return false;
    }

    /**
     * Verifica se o token no header é de um clube
     * (baseado na estrutura do seu token ou outras características)
     */
    private function isClubToken(string $authHeader): bool
    {
        // Remove "Bearer " do início
        $token = str_replace('Bearer ', '', $authHeader);
        
        // Aqui você pode implementar lógica específica para identificar tokens de clube
        // Por exemplo, verificar no banco de dados qual tipo de usuário possui este token
        
        // Implementação simples: verifica se o token existe na tabela personal_access_tokens
        // com tokenable_type = 'App\Models\Clube'
        try {
            $tokenModel = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            
            if ($tokenModel && $tokenModel->tokenable_type === 'App\Models\Clube') {
                return true;
            }
        } catch (\Exception $e) {
            // Se houver erro na verificação, assume que não é token de clube
            return false;
        }

        return false;
    }
}
