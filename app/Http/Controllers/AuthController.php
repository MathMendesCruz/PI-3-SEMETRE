<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email é obrigatório',
            'email.email' => 'Email inválido',
            'password.required' => 'Senha é obrigatória',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Tentar autenticar
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso!',
                'redirect' => route('index')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email ou senha incorretos'
        ], 401);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return view('cadastro');
    }

    public function register(Request $request)
    {
        // Validar entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nome é obrigatório',
            'name.min' => 'Nome deve ter no mínimo 3 caracteres',
            'email.required' => 'Email é obrigatório',
            'email.email' => 'Email inválido',
            'email.unique' => 'Este email já está registrado',
            'password.required' => 'Senha é obrigatória',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'Senhas não conferem',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Criar novo usuário
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Autenticar automaticamente
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Cadastro realizado com sucesso!',
                'redirect' => route('index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar conta. Tente novamente.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Desconectado com sucesso!');
    }
}
