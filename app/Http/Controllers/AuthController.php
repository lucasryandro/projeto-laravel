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
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        // Criação do usuário
        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->password),
        ]);

        // Autenticar o usuário
        $request->session()->regenerate();
        Auth::login($user);

        Session::put('id', $user->id);
        Session::put('email', $user->email);
        Session::put('nome', $user->nome);
        


        // Redirecionar ou retornar uma resposta
        return redirect()->route('users.index')->with('success', 'Registro concluído com sucesso!');
    }

    public function autenticateUser(Request $request)
    {

        $login = $request->email;
        $senha = $request->senha;

        $user = User::where('email', $login)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Usuário ou senha inválidos');
        }

        $check_password = Hash::check($senha,$user->senha);

        if(!$check_password){
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