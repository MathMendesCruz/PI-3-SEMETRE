<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        // Se já estiver logado como admin, redireciona para o dashboard
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('adm-dashboard');
        }
        
        // Se estiver logado mas não for admin
        if (Auth::check() && !Auth::user()->is_admin) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão de administrador.');
        }
        
        return view('admin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'password.required' => 'A senha é obrigatória',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Verifica se o usuário é admin
            if (Auth::user()->is_admin) {
                return redirect()->intended(route('adm-dashboard'))->with('success', 'Bem-vindo ao painel administrativo!');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Esta conta não possui permissões administrativas.',
                ])->withInput($request->only('email'));
            }
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('message', 'Você saiu do painel administrativo com sucesso.');
    }
}
