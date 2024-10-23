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
    
        $email = $request->email;
        $senha = $request->password;
        // Validação dos dados
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        $checkUser = User::where("email", $email)->first();

        if ($checkUser) {
            return redirect()->route('page.register')->with('error', 'E-mail já existente.');
        }
        
        // Nao tem nome
        // Criação do usuário
        $user = User::create([
            'nome' => "Lucas",
            'email' => $email,
            'senha' => Hash::make($senha),
        ]);

        $request->session()->regenerate();

        // Autenticar o usuário
        Auth::login($user);

        
        // Redirecionar ou retornar uma resposta
        return redirect()->route('users.pageRender');
    }

    public function autenticateUser(Request $request)
    {

        $login = $request->email;
        $senha = $request->senha;

        $user = User::where('email', $login)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Usuário ou senha inválidos');
        }


        if($user && !(Hash::check($senha, $user->senha))) {
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