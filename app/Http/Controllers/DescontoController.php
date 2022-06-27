<?php

namespace App\Http\Controllers;

use App\Http\Requests\DescontoPutValidation;
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
             'valor_desconto_porcentagem' => $request->valor_desconto_porcentagem,
             'status' => $status,
        ]);

        if($status == 'Ativo'){
            $descontoPorcentagem = ($precoProduto * $request->valor_desconto_porcentagem)/100;
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

     public function update(DescontoPutValidation $request, $id){

        $desconto = Desconto::find($id);
        $status = ucfirst($request->status);

        if($desconto != null){

            $produto =  DB::table('produtos')->where('produto', $request->produto)->get();
            if(isset($produto[0]->id) != null){
                $produtoId = $produto[0]->id;
                $precoProduto = $produto[0]->preco;
            }else{
                return response(['status' => 'Produto não existe.','produtos_disponiveis' => Produto::all('produto')], 406);
            }


            if((isset($status) != 'Ativo') && (isset($status) != 'Desativado')){
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

            $updateDesconto = $desconto->update([
                'produto_id' => ($produtoId) ? $produtoId : $desconto->produto_id,
                'cupom' => ($request->cupom) ? $request->cupom : $desconto->cupom,
                'valor_desconto_porcentagem' => ($request->valor_desconto_porcentagem) ? $request->valor_desconto_porcentagem : $desconto->valor_desconto_porcentagem,
                'status' => ($status) ? $status : $desconto->status,
            ]);


            if((isset($status) == 'Ativo') || ($desconto->status == 'Ativo')){
                $descontoPorcentagem = ($precoProduto * $request->valor_desconto_porcentagem)/100;
                $descontoPorcentagemTotal =  $precoProduto - $descontoPorcentagem;

                $produtoDesconto = Produto::find($produtoId);
                $produtoDesconto->update([
                    'preco_desconto' => $descontoPorcentagemTotal
                ]);
            }



            $response = response(['success' => $updateDesconto, 'update' => $desconto], 200);

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
