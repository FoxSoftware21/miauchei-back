<?php

namespace App\Http\Controllers\App;

use App\Helpers\UploadFileS3;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      tags={"Usuário"},
     *      path="/profile",
     *      summary="Perfil do Usuário",
     *      description="Retorno do perfil do Usuário",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function getProfile(): JsonResponse
    {
        $user = Auth::user();

        return response()->json($user);
    }

    /**
     * @OA\Post(
     *      tags={"Usuário"},
     *      path="/profile",
     *      summary="Atualização do Perfil",
     *      description="Retorna dados atualizados",
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="phone", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="photo", type="string", format="byte"),
     *                 example={"name": "Armando", "phone": "999999999", "password": "12345678", "photo": "U3dhZ2dlciByb2Nrcw=="}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function postProfile(Request $request): JsonResponse
    {
        $dados = $request->all();

        $validator = Validator::make($dados, [
            'name' => ['required'],
            'photo' => ['string'],
            'phone' => ['required'],
            'email' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->all()], 400);
        }

        $user = User::findOrFail(Auth::user()->id);
        
        $new_photo = explode(':', $dados['photo']);

        if (isset($dados['photo']) && $new_photo[0] != 'https') {
            $data = explode(',', $dados['photo']);
            $folder = 'users/';
            $name = $folder .Str::uuid() . '.jpg';
            Storage::disk('s3')->put($name, base64_decode($data[0]));
            $url = Storage::disk('s3')->url($name);
            $dados['photo'] = $url;

            $user->update($dados);
        } else {
            $user->update([
                'name' => $dados['name'],
                'email' => $dados['email'],
                'phone' => $dados['phone'],
                'photo' => $user->photo
            ]);
        }

        return response()->json(['success' => 'Usuário atualizado com sucesso!']);
    }

    // TODO Swagger
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['success' => 'Usuário deslogado com sucesso!']);
    }
}
