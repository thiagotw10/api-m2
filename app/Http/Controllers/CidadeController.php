<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;
use App\Http\Requests\CityValidation;
use App\Models\Grupo;
use Faker\Core\Number;
use Illuminate\Support\Facades\DB;

class CidadeController extends Controller
{
    public function index(Request $request){

        return Cidade::paginate($request->limit);
     }

     public function create(CityValidation $request){

       $grupo =  DB::table('grupos')->where('grupo', $request->grupo)->get();

       if(isset($grupo[0]->id) != null){
         $grupoId = $grupo[0]->id;
       }else{
            return response(['status' => 'Grupo não existe.','grupos_disponiveis' => Grupo::all('grupo')], 406);
       }

        $cidade = Cidade::create([
             'grupo_id' => $grupoId,
             'cidade' => $request->cidade
        ]);

        return response($cidade, 201);

     }

     public function show($city){

         $city = Cidade::where('cidade', 'LIKE', $city.'%')->get();
         $cidade = $city;
         $response = (isset($cidade[0]) != null)? response($cidade, 200) : response(['status' => 'cidade não existe'], 404);

         return $response;
     }

     public function update(CityValidation $request, $id){

        $cidade = Cidade::find($id);
        if($cidade != null){

            $grupo =  DB::table('grupos')->where('grupo', $request->grupo)->get();
            if(isset($grupo[0]->id) != null){
                $grupoId = $grupo[0]->id;
            }else{
                return response(['status' => 'Grupo não existe.','grupos_disponiveis' => Grupo::all('grupo')], 406);
            }

            $response = response(['success' => $cidade->update(['cidade' => $request->cidade, 'grupo_id' => $grupoId]), 'update' => $cidade], 200);

        }else{
            $response = response(['status' => 'Id não encontrado.'], 404);
        }

         return $response;

     }


     public function delete($id){
         $cidade = Cidade::find($id);

         $response = ($cidade != null)? response(['deletado' => $cidade->delete(), 'status' => 'cidade deletado com sucesso!!'], 200) : response(['status' => 'cidade não existe!!'], 404);


         return $response;
     }
}
