<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class PassportAuthController extends Controller
{

        /**
 * @OA\Post(
 *      path="/api/v1/registrar",
 *      operationId="registrar",
 *      tags={"Auth"},
 *      summary="Cadastro de usuário",
 *      description="registrar",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  required={"email","password", "name"},
 *                   @OA\Property(property="name", type="string", format="string", example="Leonardo"),
 *                  @OA\Property(
 *                      property="email",
 *                      type="string",
 *                      description="Email"
 *                  ),
 *                  @OA\Property(
 *                      property="password",
 *                      type="string",
    *                   description="Password"
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
   public function cadastrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
        ]);

        $token = $user->createToken('Senha')->accessToken;
        $response = ['Usuario cadastrado com sucesso'.$user , 'token' => $token];

        return response($response, 200);
    }


    /**
 * @OA\Post(
 *      path="/api/v1/login",
 *      operationId="Login",
 *      tags={"Auth"},
 *      summary="Login de usuário",
 *      description="Login",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  required={"email","password"},
 *                  @OA\Property(
 *                      property="email",
 *                      type="string",
 *                      description="Email"
 *                  ),
 *                  @OA\Property(
 *                      property="password",
 *                      type="string",
 *                      
 *                  ),
 *             )
 *         )
 *      ),
 *       @OA\Response(
 *          response=200,
 *          description="Sucesso. Retorna o token de acesso.",
 *       ),
 *       @OA\Response(
 *          response=401,
 *          description="Não autorizado. Usuário ou senha inválidos.",
 *      ),
 *  )
 */
    // função para login do usuário com verificação de preenchimento de campos
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('Senha')->accessToken;
            $response = ['token' => $token];
            return response($response, 200);
        } else {
            $response = "Email ou senha inválidos";
            return response($response, 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     summary="Logout de usuário",
     *     description="Logout",
     *     security={ 
     *        {"bearer": {}}
     *      },
     *     @OA\Response(
     *       response=200,
     *      description="Sucesso. Logout realizado com sucesso.",
     *   ),
     *  @OA\Response(
     *    response=401,
     *   description="Não autorizado. Token de acesso inválido.",
     * ),
     * )
     */
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response(['message' => 'Deslogado com sucesso']);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/user",
     *     operationId="user",
     *     tags={"Auth"},
     *     summary="Retorna os dados do usuário logado",
     *     description="user",
     *     security={ 
     *        {"bearer": {}}
     *      },
     *     @OA\Response(
     *       response=200,
     *      description="Sucesso. Retorna os dados do usuário logado.",
     *   ),
     *  @OA\Response(
     *    response=401,
     *   description="Não autorizado. Token de acesso inválido.",
     * ),
     * )
     */
    public function user(Request $request){
        return response(['user' => $request->user()]);
    }
}
