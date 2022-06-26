<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Desconto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DescontoValidation;

class DescontoController extends Controller
{
    public function index(Request $request){

        return Desconto::paginate($request->limit);
     }

     public function create(DescontoValidation $request){

       $produto =  DB::table('produtos')->where('produto', $request->produto)->get();
       $status = ucfirst($request->status);
       $produtoDesconto = false;

       if(isset($produto[0]->id) != null){
         $produtoId = $produto[0]->id;
         $precoProduto = $produto[0]->preco;
       }else{
            return response(['status' => 'Produto não existe.','produtos_disponiveis' => Produto::all('produto')], 406);
       }

       if(($status != 'Ativo') && ($status != 'Desativado')){
        return response(["status" => "O campo status só pode ser 'Ativo' ou 'Desativado'."], 406);
      }

       if($status == 'Ativo'){
            $campanhas = Desconto::where('status', 'Ativo')->get();
            if(isset($campanhas[0])){
                $campanhas[0]->update([
                    'status' => 'Desativado'
                    ]);
            }

        }

        $desconto = Desconto::create([
             'produto_id' => $produtoId,
             'cupom' => $request->cupom,
             'valor_desconto_porcentagem' => $request->porcentagem_desconto,
             'status' => $status,
        ]);

        if($status == 'Ativo'){
            $descontoPorcentagem = ($precoProduto * $request->porcentagem_desconto)/100;
            $descontoPorcentagemTotal =  $precoProduto - $descontoPorcentagem;

            $produtoDesconto = Produto::find($produtoId);
            $produtoDesconto->update([
                'preco_desconto' => $descontoPorcentagemTotal
            ]);
        }

        return response(['cupom_desconto' => $desconto, 'produto_aplicado' => ($produtoDesconto) ? $produtoDesconto : ''], 201);

     }

     public function show($value){

         $descontos = Desconto::where('cupom', 'LIKE', '%'.$value.'%')->get();
         $desconto = $descontos;
         $response = (isset($desconto[0]) != null)? response($desconto, 200) : response(['status' => 'Cupom não existe'], 404);

         return $response;
     }

     public function update(DescontoValidation $request, $id){

        $cidade = Desconto::find($id);
        if($cidade != null){

            $grupo =  DB::table('grupos')->where('grupo', $request->grupo)->get();
            if(isset($grupo[0]->id) != null){
                $grupoId = $grupo[0]->id;
            }else{
                return response(['status' => 'Grupo não existe.','grupos_disponiveis' => Produto::all('grupo')], 406);
            }

            $response = response(['success' => $cidade->update(['cidade' => $request->cidade, 'grupo_id' => $grupoId]), 'update' => $cidade], 200);

        }else{
            $response = response(['status' => 'Id não encontrado.'], 404);
        }

         return $response;

     }


     public function delete($id){
         $desconto = Desconto::find($id);

         $response = ($desconto != null)? response(['deletado' => $desconto->delete(), 'status' => 'Cupom deletado com sucesso!!'], 200) : response(['status' => 'Cupom não existe!!'], 404);


         return $response;
     }
}
