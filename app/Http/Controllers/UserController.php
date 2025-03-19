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
        ],[
            'file.required' => 'O campo é obrigatório.',
            'file.mimes' => 'O arquivo deve ser formato .csv',
            'file.max' => 'O tamanho do arquivo excede :max Mb.',
        ]);

        //cria um array com as colunas do banco de dados
        $headers = ['name', 'email', 'password' ];
        
        $numberRegisteredRecords = 0;
        $emailAlreadyRegistered = false;
        //receber o arquivo, ler os dados e converter a string em um array
        $dataFile = array_map('str_getcsv', file($request->file('file')));

        foreach ($dataFile as $keyData => $row) {
            $values = explode(';', $row[0]);

            foreach ($headers as $key => $header) {

                if($header == "email"){

                    if(User::where('email', $values[$key])->first()){

                        $emailAlreadyRegistered .= $values[$key] . ", ";
                    }
                }

                $arrayValues[$keyData][$header] = $values[$key];
            }
            $numberRegisteredRecords++;
        }
        
        if($emailAlreadyRegistered){
            return back()->with('error', 'Dados não Importados, existem dados ja cadastrados.:<br> ' .
            $emailAlreadyRegistered);
        }

        //cadastrar registros no banco de dados
        User::insert($arrayValues);

        return back()->with('success', 'Dados Importados com sucesso <br>Quantidade: ' .
        $numberRegisteredRecords);
    }
}
