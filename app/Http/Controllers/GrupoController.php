<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoValidation;
use App\Models\Grupo;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class GrupoController extends Controller
{

    public function index(Request $request){

       return Grupo::with(['cidades', 'campanhas'])->paginate($request->limit);
    }

    public function create(GrupoValidation $request){

       $grupo = Grupo::create([
            'grupo' => $request->grupo
       ]);

       return response($grupo, 201);

    }

    public function show($id){

        $grupo = Grupo::with('cidades')->with(['campanhas' => function($q){ return $q->where('status', 'Ativo');}, 'produtos'])->find($id);
        $response = ($grupo != null)? response($grupo, 200) : response(['status' => 'Grupo não existe'], 404);

        return $response;
    }

    public function update(GrupoValidation $request, $id){

        $grupo = Grupo::find($id);

        $response = ($grupo != null) ? response(['success' => $grupo->update(['grupo' => $request->grupo ]), 'update' => $grupo], 200) : response(['status' => 'Grupo não encontrado.'], 404);



        return $response;

    }


    public function delete($id){
        $grupo = Grupo::find($id);

        $response = ($grupo != null)? response(['deletado' => $grupo->delete(), 'status' => 'Grupo deletado com sucesso!!'], 200) : response(['status' => 'Grupo não existe!!'], 404);


        return $response;
    }

}
