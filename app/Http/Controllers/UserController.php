<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::get();
        // Carregar a view
        return view('users.index', ['users' => $users]);
    }

    public function import(Request $request){
        // Validação do arquivo
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'  
        ]);

        dd('Continuação');
    }
}
