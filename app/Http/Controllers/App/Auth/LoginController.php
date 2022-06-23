<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/login",
     *      summary="Login de Usuário",
     *      description="Retorna usuário logado",
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="device_name", type="string"),
     *                 example={"email": "armandinho14.ap@gmail.com", "password": "12345678", "device_name": "Swagger"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => "As credenciais de login são inválidas."], 401);
        }

        $token = auth()->user()->createToken($request->get('device_name'));

        $response = [
            'status' => true,
            'authorization' => $token->plainTextToken,
            'success' => 'Login efetuado com sucesso!',
            'user' => Auth::user()
        ];

        return $response;
    }
}
