<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use App\Models\TelefonePessoa;
use App\Models\EmailPessoa;
use Illuminate\Http\Request;
use App\Http\Resources\v1\PessoaResource;


class PessoaController extends Controller
{
 
    /**
     * @OA\Get(
     *      path="/api/v1/pessoas",
     *      operationId="getPessoasList",
     *      tags={"Pessoas"},
     *      summary="Lista de pessoas",
     *      description="Retorna uma lista de pessoas",
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso. Lista de pessoas retornada com sucesso.",
     *       ),
     *       @OA\Response(
     *         response=400,
     *           description="Erro. Não foi possível retornar a lista de pessoas."
     *      ),
     * 
     *  )
     */
    public function index()
    {
        try {
            if (Pessoa::count() > 0) {
                return [
                    'status' => 200, 
                    'message' => 'Dados encontrados com sucesso!',
                    'Dados' => PessoaResource::collection(Pessoa::paginate(2)),
                ];
              
            } else {
              return response()->json(['message' => 'Nenhuma pessoa cadastrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    // SWAGGER OA POST with parameters (nomePessoa, dataNascimento, cpf, rg)

    /**
     * @OA\Post(
     *      path="/api/v1/pessoas",
     *      operationId="store",
     *      tags={"Pessoas"},
     *      summary="Cadastro de pessoa",
     *      description="store",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"nomePessoa","dataNascimento", "cpf", "rg"},
     *                   @OA\Property(property="nomePessoa", type="string", format="string", example="Leonardo"),
     *                  @OA\Property(
     *                      property="dataNascimento",
     *                      type="string",
     *                      description="Data de nascimento"
     *                  ),
     *                  @OA\Property(
     *                      property="cpf",
     *                      type="string",
     *                      description="CPF"
     *                  ),
     *                  @OA\Property(
     *                      property="rg",
     *                      type="string",
     *                      description="RG"
     *                  ),
     *             )
     *         )
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Sucesso. Cadastro realizado com sucesso.",
     *       ),
     *       @OA\Response(
     *         response=400,
     *           description="Erro. Não foi possível realizar o cadastro."
     *      ),
     * 
     *  )
     */
  
    public function store(Request $request)
    {
        try {
            if (empty($request->nomePessoa)) {
                return response()->json(['message' => 'O campo nomePessoa é obrigatório'], 400);
            }
            if (empty($request->dataNascimento)) {
                return response()->json(['message' => 'O campo dataNascimento é obrigatório'], 400);
            }
            if (empty($request->cpf)) {
                return response()->json(['message' => 'O campo cpf é obrigatório'], 400);
            }
            if (empty($request->rg)) {
                return response()->json(['message' => 'O campo rg é obrigatório'], 400);
            }
            
            $pessoa = new Pessoa();
            $pessoa->nomePessoa = $request->nomePessoa;
            $pessoa->dataNascimento = $request->dataNascimento;
            $pessoa->cpf = $request->cpf;
            $pessoa->rg = $request->rg;
            $pessoa->save();
            return response()->json(['message' => 'Pessoa cadastrada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

     
    // SWAGGER OA PUT with parameters (nomePessoa, dataNascimento, cpf, rg)
    /**
     * @OA\Get(
     *     path="/api/v1/pessoas/{id}",
     *    tags={"Pessoas"},
     *    summary="Mostra uma pessoa",
     *   description="Mostra uma pessoa",
     *    operationId="show",
     *   @OA\Parameter(
     *        name="id",
     *       in="path",
     *      description="ID da pessoa",
     *      required=true,
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\Response(
     *        response=200,
     *      description="Sucesso. Pessoa retornada com sucesso.",
     *  ),
     * @OA\Response(
     *       response=400,
     *     description="Erro. Não foi possível retornar a pessoa."
     * ),
     * )
     */
    
    public function show($id)
    {
        try {
            $pessoa = Pessoa::find($id);
            if ($pessoa) {
                return response()->json(['message' => 'Pessoa encontrada com sucesso!', 'Dados' => $pessoa], 200);
            } else {
                return response()->json(['message' => 'Pessoa não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


     // SWAGGER OA PUT with parameters (nomePessoa, dataNascimento, cpf, rg)
    /**
     * @OA\Put(
     *     path="/api/v1/pessoas/{id}",
     *    tags={"Pessoas"},
     *    operationId="update",
     *   summary="Atualização de pessoa",
     *  description="update",
     *  @OA\Parameter(
     *        name="id",
     *       in="path",
     *      description="ID da pessoa",
     *    required=true,
     *  @OA\Schema(
     *         type="integer"
     *     )
     * ),
     * @OA\RequestBody(
     *         required=true,
     *        @OA\MediaType(mediaType="multipart/form-data",
     *            @OA\Schema(
     *               required={"nomePessoa","dataNascimento", "cpf", "rg"},
     *               @OA\Property(property="nomePessoa", type="string", format="string", example="Leonardo"),
     *              @OA\Property(
     *                 property="dataNascimento",
     *                type="string",
     *              description="Data de nascimento"
     *         ),
     *        @OA\Property(
     *          property="cpf",
     *        type="string",
     *     description="CPF"
     * ),
     * @OA\Property(
     *   property="rg",
     *   schema="string",
     *  description="RG"
     * ),
     * )
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Sucesso. Atualização realizada com sucesso.",
     * ),
     * @OA\Response(
     *  response=400,
     * description="Erro. Não foi possível realizar a atualização."
     * ),
     * )
     */
    public function update(Request $request, $id)
    {
        // tente editar uma pessoa se ao menos um dos campos estiver preenchido e verificar se o email, cpf e rg já existem se sim, retorne uma mensagem de erro informando que o email, cpf e rg já existem
        try {
            if (empty($request->nomePessoa) && empty($request->dataNascimento) && empty($request->cpf) && empty($request->rg)) {
                return response()->json(['message' => 'Para atualizar uma pessoa é necessário preencher ao menos um dos campos (nomePessoa, dataNascimento, cpf, rg)'], 400);
            }
            $pessoa = Pessoa::find($id);
            if ($pessoa) {
                if (!empty($request->nomePessoa)) {
                    $pessoa->nomePessoa = $request->nomePessoa;
                }
                if (!empty($request->dataNascimento)) {
                    $pessoa->dataNascimento = $request->dataNascimento;
                }
                if (!empty($request->cpf)) {
                    $pessoa->cpf = $request->cpf;
                }
                if (!empty($request->rg)) {
                    $pessoa->rg = $request->rg;
                }
                $pessoa->save();
                return response()->json(['message' => 'Pessoa atualizada com sucesso!'], 200);
            } else {
                return response()->json(['message' => 'Pessoa não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    // SWAGGER OA DELETE with parameters (id)
    /**
     * @OA\Delete(
     *     path="/api/v1/pessoas/{id}",
     *    tags={"Pessoas"},
     *    operationId="destroy",
     *   summary="Exclusão de pessoa",
     *  description="destroy",
     *  @OA\Parameter(
     *        name="id",
     *       in="path",
     *      description="ID da pessoa",
     *    required=true,
     *  @OA\Schema(
     *         type="integer"
     *     )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Sucesso. Exclusão realizada com sucesso.",
     * ),
     * @OA\Response(
     *  response=400,
     * description="Erro. Não foi possível realizar a exclusão."
     * ),
     * )
     */
    public function destroy($id)
    {
        try {
            $pessoa = Pessoa::find($id);
            if ($pessoa) {
                $pessoa->delete();
                return response()->json(['message' => 'Pessoa excluída com sucesso!'], 200);
            } else {
                return response()->json(['message' => 'Pessoa não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
