<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Campanha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProdutoValidation;

class ProdutoController extends Controller
{
    public function index(Request $request){

        return Produto::with('descontos')->paginate($request->limit);
     }

     public function create(ProdutoValidation $request){

       $campanha =  DB::table('campanhas')->where('campanha', $request->campanha)->get();

       if(isset($campanha[0]->id) != null){
         $campanhaId = $campanha[0]->id;
       }else{
            return response(['status' => 'Campanha não existe.','campanhas_disponiveis' => Campanha::all('campanha')], 406);
       }

        $produto = Produto::create([
             'campanha_id' => $campanhaId,
             'produto' => $request->produto,
             'preco' => $request->preco
        ]);

        return response($produto, 201);

     }

     public function show($value){

         $produto = Produto::with(['descontos' => function($val){return $val->where('status', 'Ativo');}])->where('produto', 'LIKE', $value.'%')->get();
         $produtos = $produto;
         $response = (isset($produtos[0]) != null)? response($produtos, 200) : response(['status' => 'produto não existe'], 404);

         return $response;
     }

     public function update(Request $request, $id){

        $produto = Produto::find($id);
        if($produto != null){

            $campanha =  DB::table('campanhas')->where('campanha', $request->campanha)->get();
            if(isset($campanha[0]->id) != null){
                $campanhaId = $campanha[0]->id;
            }else{
                return response(['status' => 'Campanha não existe.','campanhas_disponiveis' => Campanha::all('campanha')], 406);
            }

            $updateProduto = $produto->update([
                'produto' => ($request->produto) ? $request->produto : $produto->produto,
                'preco' => ($request->preco) ? $request->preco : $produto->preco,
                'campanha_id' => $campanhaId
            ]);

            $response = response(['success' => $updateProduto, 'update' => $produto], 200);

        }else{
            $response = response(['status' => 'Id não encontrado.'], 404);
        }

         return $response;

     }


     public function delete($id){
         $cidade = Produto::find($id);

         $response = ($cidade != null)? response(['deletado' => $cidade->delete(), 'status' => 'produto deletado com sucesso!!'], 200) : response(['status' => 'produto não existe!!'], 404);


         return $response;
     }
}
