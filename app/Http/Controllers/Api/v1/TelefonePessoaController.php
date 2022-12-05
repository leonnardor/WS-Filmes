<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use App\Models\TelefonePessoa;
use Illuminate\Http\Request;
use App\Http\Resources\v1\PessoaResource;
use App\Http\Resources\v1\TelefonePessoaResource;

class TelefonePessoaController extends Controller
{
    

    /**
     * @OA\Get(
     *     path="/api/v1/telefonePessoas",
     *    operationId="getTelefonePessoasList",
     *   tags={"TelefonePessoas"},
     *  summary="Lista de telefones de pessoas",
     * description="Retorna uma lista de telefones de pessoas",
     * @OA\Response(
     *    response=200,
     *  description="Sucesso. Lista de telefones de pessoas retornada com sucesso.",
     * ),
     * @OA\Response(
     *   response=400,
     * description="Erro. Não foi possível retornar a lista de telefones de pessoas."
     * ),
     * )
     */
    
    public function index()
    {
         try {
                if (Pessoa::count() > 0) {
                  return [
                 'status' => 200, 
                 'message' => 'Dados encontrados com sucesso!',
                 'Dados' => TelefonePessoaResource::collection(TelefonePessoa::paginate(10)),
                  ];
                  
                } else {
                  return response()->json(['message' => 'Nenhuma pessoa cadastrada'], 404);
                }
          } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
          }
    }

    // SWAGGER OA POST with parameters (telefonePessoa, idPessoa)
    

    /**
     * @OA\Post(
     *    path="/api/v1/telefonePessoas",
     *  tags={"TelefonePessoas"},
     * summary="Cadastro de telefone de pessoa",
     * description="store",
     * @OA\RequestBody(
     *   required=true,
     * @OA\MediaType(
     *  mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(
     * property="telefonePessoa",
     * type="string",
     * example="11999999999"
     * ),
     * @OA\Property(
     * property="idPessoa",
     * type="integer",
     * example="1"
     * ),
     * ),
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Sucesso. Telefone de pessoa cadastrado com sucesso.",
     * ),
     * @OA\Response(
     * response=400,
     * description="Erro. Não foi possível cadastrar o telefone de pessoa."
     * ),
     * )
     */
    
    public function store(Request $request)
    {
        // cadastrar telefone atrelado a pessoa pelo id da pessoa 
                 try {
            $pessoa = Pessoa::find($request->idPessoa);
            $telefone = new TelefonePessoa();
            $telefone->numeroTelefone = $request->numeroTelefone;
            $telefone->operadoraTelefone = $request->operadoraTelefone;
            $telefone->pessoa()->associate($pessoa); // associando o telefone a pessoa pelo id da pessoa 
            $telefone->save();
            return response()->json(['message' => 'Telefone cadastrado com sucesso!', 'Dados' => $telefone], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
    }

    // SWAGGER OA GET with parameters (id)
    /**
     * @OA\Get(
     *    path="/api/v1/telefonePessoas/{id}",
     * tags={"TelefonePessoas"},
     * summary="Exibir telefone de pessoa",
     * description="show",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID do telefone de pessoa",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Sucesso. Telefone de pessoa exibido com sucesso.",
     * ),
     * @OA\Response(
     * response=400,
     * description="Erro. Não foi possível exibir o telefone de pessoa."
     * ),
     * )
     */
    public function show($id)
    {
        // mostrar telefone pelo o id do telefone
        try {
            $telefone = TelefonePessoa::find($id);
            if ($telefone) {
                return response()->json(['message' => 'Dados encontrados com sucesso!', 'Dados' => $telefone], 200);
            } else {
                return response()->json(['message' => 'Telefone não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
    }

    

    /**
     * @OA\Put(
     *   path="/api/v1/telefonePessoas/{id}",
     * tags={"TelefonePessoas"},
     * summary="Atualizar telefone de pessoa",
     * description="update",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID do telefone de pessoa",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * ),
     * ),
     * @OA\RequestBody(
     *  required=true,
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(
     * property="telefonePessoa",
     * type="string",
     * example="11999999999"
     * ),
     * @OA\Property(
     * property="idPessoa",
     * type="integer",
     * example="1"
     * ),
     * ),
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Sucesso. Telefone de pessoa atualizado com sucesso.",
     * ),
     * @OA\Response(
     * response=400,
     * description="Erro. Não foi possível atualizar o telefone de pessoa."
     * ),
     * )
     */

   //update telefone de pessoa pelo id do telefone
    public function update(Request $request, $id)
    {
        try {
            $telefone = TelefonePessoa::find($id);
            if ($telefone) {
                $telefone->numeroTelefone = $request->numeroTelefone;
                $telefone->operadoraTelefone = $request->operadoraTelefone;
                $telefone->idPessoa = $request->idPessoa;
                $telefone->save();
                return response()->json(['message' => 'Telefone atualizado com sucesso!', 'Dados' => $telefone], 200);
            } else {
                return response()->json(['message' => 'Telefone não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    /**
     * @OA\Delete(
     *  path="/api/v1/telefonePessoas/{id}",
     * tags={"TelefonePessoas"},
     * summary="Deletar telefone de pessoa",
     * description="destroy",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID do telefone de pessoa",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Sucesso. Telefone de pessoa deletado com sucesso.",
     * ),
     * @OA\Response(
     * response=400,
     * description="Erro. Não foi possível deletar o telefone de pessoa."
     * ),
     * )
     */


    public function destroy($id)
    {
        // deletar telefone pelo id do telefone
        try {
            $telefone = TelefonePessoa::find($id);
            if ($telefone) {
                $telefone->delete();
                return response()->json(['message' => 'Telefone deletado com sucesso!'], 200);
            } else {
                return response()->json(['message' => 'Telefone não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
