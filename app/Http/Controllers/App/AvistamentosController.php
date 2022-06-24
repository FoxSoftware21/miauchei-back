<?php

namespace App\Http\Controllers\App;

use App\Helpers\DifferentDates;
use App\Http\Controllers\Controller;
use App\Models\Avistamentos;
use App\Models\Pets;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AvistamentosController extends Controller
{
    private $dates_differents;

    public function __construct(DifferentDates $differentDates)
    {
        $this->dates_differents = $differentDates;
    }

    /**
     * @OA\Get(
     *      tags={"Pets"},
     *      path="/pets/avistados",
     *      summary="Pets avistados",
     *      description="Retorna lista de pets avistados",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=400,description="Bad Request"),
     * )
     */
    public function petsAvistados(): JsonResponse
    {
        $petsSighted = Pets::join('users', 'pets.user_id', '=', 'users.id')
            ->join('status', 'pets.status_id', '=', 'status.id')
            ->select('users.name as dono', 'pets.*', 'status.name as status',)
            ->where('status_id', 3)
            ->orderBy('data_desaparecimento', 'DESC')
            ->get();

        $lists = [];
        $list = [];
        for ($i = 0; $i < count($petsSighted); $i++) {
            $lists[$i] = $petsSighted[$i];
            $lists[$i]['count'] = Avistamentos::where('pet_id', $lists[$i]->id)->count();
            $lists[$i]->avistamentos = Avistamentos::select('ultima_vez_visto', 'data_avistamento')
                ->where('pet_id', $petsSighted[$i]->id)->latest()->first();

            $lists[$i]->times = $this->dates_differents->dateFormat($petsSighted[$i]->created_at);
            if ($lists[$i]['count'] > 0) {
                $list[$i] = $lists[$i];
            }
        }

        return response()->json($petsSighted);
    }

    /**
     * @OA\Get(
     *      tags={"Pets"},
     *      path="/pets/avistamentos/{id}",
     *      summary="Avistamentos do pet",
     *      description="Retorna os avistamentos do pet conforme id passado",
     *      security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         description="ID do pet",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function petsAvistamentos(int $id): JsonResponse
    {
        $pet = Pets::select('pets.*')->where('pets.id', $id)->get();

        for ($i = 0; $i < count($pet); $i++) {
            $pet[$i]->publicado = $pet[$i]->data_desaparecimento;

            $pet[$i]->avistamentos = Avistamentos::join('users', 'avistamentos.user_id', '=', 'users.id')
                ->select('avistamentos.*', 'users.name as dono')->where('avistamentos.pet_id', $pet[$i]->id)->get();

            for ($y = 0; $y < count($pet[$i]->avistamentos); $y++) {
                $pet[$i]->avistamentos[$y]['data_perdido'] = $pet[$i]->data_desaparecimento;
            }
        }

        return response()->json($pet);
    }

    /**
     * @OA\Post(
     *      tags={"Pets"},
     *      path="/pets/avistamentos/store",
     *      summary="Cadastrar avistamentos",
     *      description="Retorna dados do avistamento",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data_avistamento", type="string"),
     *                 @OA\Property(property="pet_id", type="string"),
     *                 @OA\Property(property="ultima_vez_visto", type="string"),
     *                 @OA\Property(property="esta_com_pet", type="string"),
     *                 example={"data_avistamento": "05/04/2022", "pet_id": "345", "ultima_vez_visto": "Rua teste", "esta_com_pet": "0"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function petsAvistamentosStore(Request $request): JsonResponse
    {
        $dados = $request->all();

        $validator = Validator::make($dados, [
            'data_avistamento' => ['required'],
            'pet_id' => ['required'],
            'ultima_vez_visto' => ['required'],
            'esta_com_pet' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $dados['user_id'] = Auth::user()->id;
        $dados['esta_com_pet'] = intval($dados['esta_com_pet']);

        Avistamentos::create($dados);

        $pet = Pets::findOrFail($dados['pet_id']);
        $pet->status_id = 3;
        $pet->save();

        return response()->json(['success' => 'Cadastro efetuado com sucesso!']);
    }
}
