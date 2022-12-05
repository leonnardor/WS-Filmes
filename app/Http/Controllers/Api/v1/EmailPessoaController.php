<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\emailPessoa;
use Illuminate\Http\Request;
use App\Http\Resources\v1\EmailPessoaResource;

class EmailPessoaController extends Controller
{
    

    /**
     * @OA\Get(
     *      path="/api/v1/emailPessoas",
     *      operationId="getEmailPessoasList",
     *      tags={"EmailPessoas"},
     *      summary="Lista de emails de pessoas",
     *      description="Retorna uma lista de emails de pessoas",
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso. Lista de emails de pessoas retornada com sucesso.",
     *       ),
     *       @OA\Response(
     *         response=400,
     *           description="Erro. Não foi possível retornar a lista de emails de pessoas."
     *      ),
     * 
     *  )
     */
    public function index()
    {
        try {
            if (emailPessoa::count() > 0) {
                return [
                    'status' => 200, 
                    'message' => 'Email retornados com sucesso!',
                    'Dados' => EmailPessoaResource::collection(emailPessoa::paginate(10)),
                ];
              
            } else {
              return response()->json(['message' => 'Nenhum email cadastrado'], 404);
            }
      } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
      }
    }

    
    // SWAGGER OA POST with parameters (emailPessoa, idPessoa)
    /** 
     * @OA\Post(
     *     path="/api/v1/emailPessoas",
     *    tags={"EmailPessoas"},
     *    summary="Cadastro de email de pessoa",
     *   description="store",
     *    @OA\RequestBody(
     *       required=true,
     *      @OA\MediaType(
     *         mediaType="multipart/form-data",
     *         @OA\Schema(
     *           required={"emailPessoa","idPessoa"},
     *          @OA\Property(property="emailPessoa", type="string", format="string", example="leonnardo1588@gmail.com"),
     *         @OA\Property(property="idPessoa", type="integer", format="int64", example="1"),
     *       ),
     *    ),
     * ),
     *  @OA\Response(
     *    response=200,
     *   description="Sucesso. Email de pessoa cadastrado com sucesso.",
     * ),
     * @OA\Response(
     *   response=400,
     * description="Erro. Não foi possível cadastrar o email de pessoa."
     * ),
     * )
     */
   
     
    public function store(Request $request)
    {
        try {
            if ($request->has('email') && $request->has('idPessoa')) {
                if (emailPessoa::where('email', $request->email)->count() > 0) {
                    return response()->json(['message' => 'Email já cadastrado'], 400);
                } else {
                    $emailPessoa = new emailPessoa();
                    $emailPessoa->email = $request->email;
                    $emailPessoa->idPessoa = $request->idPessoa;
                    $emailPessoa->save();
                    return response()->json(['message' => 'Email cadastrado com sucesso!'], 200);
                }
            } else {
                return response()->json(['message' => 'Preencha todos os campos!'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
       

    //* SWAGGER OA GET with parameters (id)
    /**
     * @OA\Get(
     *      path="/api/v1/emailPessoas/{id}",
     *      operationId="getEmailPessoaById",
     *      tags={"EmailPessoas"},
     *      summary="Busca de email de pessoa pelo id",
     *      description="Retorna um email de pessoa pelo id",
     *      @OA\Parameter(
     *          name="id",
     *          description="id do email de pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso. Email de pessoa encontrado com sucesso.",
     *       ),
     *       @OA\Response(
     *         response=400,
     *           description="Erro. Não foi possível encontrar o email de pessoa."
     *      ),
     * 
     *  )
     */
    public function show($id)
    {
      
        try {
            $email = emailPessoa::find($id);
            if ($email) {
                return [
                    'status' => 200,
                    'message' => 'Email encontrados com sucesso!',
                    'Dados' => $email,
                ];
            } else {
                return response()->json(['message' => 'Email não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    //* SWAGGER OA PUT with parameters (id, emailPessoa, idPessoa)
    /**
     * @OA\Put(
     *     path="/api/v1/emailPessoas/{id}",
     *    tags={"EmailPessoas"},
     *    summary="Atualização de email de pessoa",
     *   description="update",
     *    @OA\Parameter(
     *          name="id",
     *          description="id do email de pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *    @OA\RequestBody(
     *       required=true,
     *      @OA\MediaType(
     *         mediaType="multipart/form-data",
     *         @OA\Schema(
     *           required={"emailPessoa","idPessoa"},
     *          @OA\Property(property="emailPessoa", type="string", format="string", example="leonnardo1588@gmail.com"),
     *        @OA\Property(property="idPessoa", type="integer", format="int64", example="1"),
     *      ),
     *   ),
     * ),
     * @OA\Response(
     *   response=200,
     * description="Sucesso. Email de pessoa atualizado com sucesso.",
     * ),
     * @OA\Response(
     *  response=400,
     * description="Erro. Não foi possível atualizar o email de pessoa."
     * ),
     * )
     */

     // verificar se ao menos um dos campos foi preenchido para atualizar o registro e se o email já não está cadastrado
    public function update(Request $request, $id)
    {
       try {
            if ($request->has('email') || $request->has('idPessoa')) {
                $email = emailPessoa::find($id);
                if ($email) {
                    if ($request->has('email')) {
                        if (emailPessoa::where('email', $request->email)->count() > 0) {
                            return response()->json(['message' => 'Email já cadastrado'], 400);
                        } else {
                            $email->email = $request->email;
                        }
                    }
                    if ($request->has('idPessoa')) {
                        $email->idPessoa = $request->idPessoa;
                    }
                    $email->save();
                    return response()->json(['message' => 'Email atualizado com sucesso!'], 200);
                } else {
                    return response()->json(['message' => 'Email não encontrado'], 404);
                }
            } else {
                return response()->json(['message' => 'Preencha ao menos um campo para atualizar!'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    //* SWAGGER OA DELETE with parameters (id)
    /**
     * @OA\Delete(
     *     path="/api/v1/emailPessoas/{id}",
     *    tags={"EmailPessoas"},
     *    summary="Exclusão de email de pessoa",
     *   description="destroy",
     *    @OA\Parameter(
     *          name="id",
     *          description="id do email de pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     * @OA\Response(
     *   response=200,
     * description="Sucesso. Email de pessoa excluído com sucesso.",
     * ),
     * @OA\Response(
     *  response=400,
     * description="Erro. Não foi possível excluir o email de pessoa."
     * ),
     * )
     */
    public function destroy($id)
    {
        try {
            $email = emailPessoa::find($id);
            if ($email) {
                $email->delete();
                return response()->json(['message' => 'Email excluído com sucesso!'], 200);
            } else {
                return response()->json(['message' => 'Email não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
