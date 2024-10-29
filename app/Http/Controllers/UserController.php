<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Log;

class UserController extends Controller
{
    public function index()
    {
        // Obtém todos os usuários
        $users = User::get()->toArray();

        Log::info($users);
        return view('indexAdmin')->with('users', $users);
    }

    public function pageRender()
    {
        $users = User::get()->toArray();
        
        return view('indexAdmin', ['users' => $users]);
    }

    public function create()
    {
        return view('register'); // Retorna a view de registro
    }

    public function store(Request $request)
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

        // Autenticar o usuário (opcional)
        Auth::login($user);

        // Redirecionar para a lista de usuários
        return redirect()->route('users.index')->with('success', 'Usuário registrado com sucesso!');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user')); // Retorna a view de detalhes do usuário
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user')); // Retorna a view para edição do usuário
    }

    public function update(Request $request)
    {
       $id = $request->id;
       $nome = $request->nome;
       $senha = $request->password;
       $email = $request->email;

       $user = User::find($id);
       if(!$user){
            return "error";
       }
       $user->nome = $nome;
       $user->email = $email;

       if($senha){
        $user->senha = Hash::make($senha);

       }
       $user->save();

       return redirect()->route('users.pageRender');
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        $user->delete(); // Deleta o usuário
        return redirect()->route('users.pageRender')->with('success', 'Usuário removido com sucesso!');
    }

    public function updateView($id)
    {
        $user = User::find($id)->toArray(); // Deleta o usuário
        return view('editAdmin')->with('user', $user);
    }
}