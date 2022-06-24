<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Campanha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CampanhaValidation;

class CampanhaController extends Controller
{
    public function index(Request $request){

        return Campanha::paginate($request->limit);
     }

     public function create(CampanhaValidation $request){

       $grupo =  DB::table('grupos')->where('grupo', $request->grupo)->get();

       $status = ucfirst($request->status);

       if(isset($grupo[0]->id) != null){
         $grupoId = $grupo[0]->id;
       }else{
            return response(['status' => 'Grupo não existe.','grupos_disponiveis' => Grupo::all('grupo')], 406);
       }

       if(($status != 'Ativo') && ($status != 'Desativado')){
            return response(["status" => "O campo status só pode ser 'Ativo' ou 'Desativado'."], 406);
       }

       if($status == 'Ativo'){
            $campanhas = Campanha::where('status', 'Ativo')->get();
            if(isset($campanhas[0])){
                $campanhas[0]->update([
                    'status' => 'Desativado'
                    ]);
            }

       }


        $campanha = Campanha::create([
             'grupo_id' => $grupoId,
             'campanha' => $request->campanha,
             'descricao' => $request->descricao,
             'url_imagem' => $request->url_imagem,
             'status' => $status,
        ]);

        return response($campanha, 201);

     }

     public function show($value){

         $campanhas = Campanha::where('campanha', 'LIKE', $value.'%')->get();
         $campanha = $campanhas;
         $response = (isset($campanha[0]) != null)? response($campanha, 200) : response(['status' => 'campanha não existe'], 404);

         return $response;
     }

     public function update(Request $request, $id){

        $campanha = Campanha::find($id);
        $status = ucfirst($request->status);

        if($campanha != null){

            $grupo =  DB::table('grupos')->where('grupo', $request->grupo)->get();
            if(isset($grupo[0]->id) != null){
                $grupoId = $grupo[0]->id;
            }else{
                return response(['status' => 'Grupo não existe.','grupos_disponiveis' => Grupo::all('grupo')], 406);
            }

            if($status == 'Ativo'){
                $campanhas = Campanha::where('status', 'Ativo')->get();
                if(isset($campanhas[0])){
                    $campanhas[0]->update([
                        'status' => 'Desativado'
                        ]);
                }

           }

           $update = $campanha->update([
                'campanha' => ($request->campanha) ? $request->campanha : $campanha->campanha,
                'descricao' => ($request->descricao) ? $request->descricao : $campanha->descricao,
                'url_imagem' => ($request->url_imagem) ? $request->url_imagem : $campanha->url_imagem,
                'status' => ($status) ? $status : $campanha->status,
                'grupo_id' => ($grupoId) ? $grupoId : $campanha->grupo_id
            ]);

            $response = response(['update' => $update ], 200);

        }else{
            $response = response(['status' => 'Id não encontrado.'], 404);
        }

         return $response;

     }


     public function delete($id){
         $campanha = Campanha::find($id);

         $response = ($campanha != null)? response(['deletado' => $campanha->delete(), 'status' => 'campanha deletado com sucesso!!'], 200) : response(['status' => 'campanha não existe!!'], 404);


         return $response;
     }
}
