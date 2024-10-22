<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Autenticar o usuário
        Auth::login($user);


        // Redirecionar ou retornar uma resposta
        return redirect()->route('users.index')->with('success', 'Registro concluído com sucesso!');
    }

    public function login(Request $request)
    {


        // Validação dos dados
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        Log::info("Login Entrou");
        Log::info("-----------------------------------------");

        // Verificar as credenciais e autenticar o usuário
        if (Auth::attempt($credentials)) {
            Log::info("Login bem-sucedido");
            Log::info("-----------------------------------------");

            // Login bem-sucedido
            $request->session()->regenerate();

            Session::put('user', "teste");



            return redirect()->intended('index')->with('teste', 'Login bem-sucedido!');
        }

        // Se as credenciais estiverem erradas
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }

    public function autenticateUser(Request $request)
    {

        $login = $request->email;
        $senha = $request->senha;

        $user = User::where('email', $login)->where('senha', $senha)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Usuário ou senha inválidos');
        }

        $request->session()->regenerate();

        Auth::login($user);

        Session::put('id', $user->id);
        Session::put('email', $user->email);
        Session::put('nome', $user->nome);


        return redirect()->route('users.pageRender');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function logoutUser(Request $request)
    {
       Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();
       return redirect()->route('Home');
    }


}