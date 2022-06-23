<?php

namespace App\Http\Controllers\App;

use App\Helpers\DifferentDates;
use App\Helpers\UploadFileS3;
use App\Http\Controllers\Controller;
use App\Models\Avistamentos;
use App\Models\Pets;
use App\Models\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetsController extends Controller
{
    private $dates_differents;

    public function __construct(DifferentDates $differentDates)
    {
        $this->dates_differents = $differentDates;
    }

    /**
     * @OA\Get(
     *      tags={"Pets"},
     *      path="/recents",
     *      summary="Pets recente",
     *      description="Retorno de pets cadastrados recentemente",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *      @OA\Response(response=200,description="Successful operation",),
     *      @OA\Response(response=400,description="Bad Request"),
     * )
     */
    public function petRecents(): JsonResponse
    {
        $recentPets = Pets::select('*')
            ->where('status_id', 1)
            ->OrWhere('status_id', 3)
            ->limit(10)
            ->orderBy('created_at', 'DESC')
            ->get();

        for ($i = 0; $i < count($recentPets); $i++) {
            $recentPets[$i]->avistamentos = Avistamentos::select('ultima_vez_visto', 'data_avistamento')
                ->where('pet_id', $recentPets[$i]->id)
                ->orderBy('created_at', 'DESC')
                ->first();

            $recentPets[$i]->times = $this->dates_differents->dateFormat($recentPets[$i]->created_at);
        }

        if (count($recentPets) == 0) {
            return response()->json(['message' => 'Sem registros']);
        }

        return response()->json($recentPets);
    }

    /**
     * @OA\Get(
     *      tags={"Pets"},
     *      path="/mypets",
     *      summary="Meus Pets",
     *      description="Retorno dos pets cadastrados pelo usuário logado",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=400,description="Bad Request"),
     * )
     */
    public function myPets(): JsonResponse
    {
        $myPets = Pets::join('users', 'pets.user_id', '=', 'users.id')
            ->join('status', 'pets.status_id', '=', 'status.id')
            ->select('pets.*', 'status.name as status')
            ->where('users.id', Auth::user()->id)
            ->orderBy('pets.data_desaparecimento', 'ASC')
            ->get();

        $result = [];
        for ($i = 0; $i < count($myPets); $i++) {
            $result[$i]['id']                   = $myPets[$i]['id'];
            $result[$i]['nome']                 = $myPets[$i]['nome'];
            $result[$i]['data_desaparecimento'] = date_create($myPets[$i]->data_desaparecimento)->format('d/m/Y');
            $result[$i]['foto']                 = $myPets[$i]['foto'];
            $result[$i]['status']               = $myPets[$i]['status'];
        }

        return response()->json($result);
    }

    /**
     * @OA\Get(
     *      tags={"Pets"},
     *      path="/pets-lost",
     *      summary="Pets perdidos",
     *      description="Retorna lista de pets perdidos",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=400,description="Bad Request"),
     * )
     */
    public function petsLost(): JsonResponse
    {
        $petsLost = Pets::select('*')
            ->where('status_id', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        for ($i = 0; $i < count($petsLost); $i++) {
            $petsLost[$i]->avistamentos = Avistamentos::select('ultima_vez_visto', 'data_avistamento')
                ->where('pet_id', $petsLost[$i]->id)->latest()->first();
            $petsLost[$i]->times = $this->dates_differents->dateFormat($petsLost[$i]->created_at);
        }

        if (count($petsLost) <= 0) {
            return response()->json(['message' => 'Sem registros']);
        }

        return response()->json($petsLost);
    }

    /**
     * @OA\Get(
     *      tags={"Pets"},
     *      path="/pets-details/{id}",
     *      summary="Detalhes do pet",
     *      description="Retorna detalhes do pet conforme id passado",
     *      security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         description="ID do pet",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function petsDetails(int $id): JsonResponse
    {
        $pets = Pets::findOrFail($id);

        $dateFormat = date_create($pets->data_desaparecimento);

        $pets->data_desaparecimento = date_format($dateFormat, 'd/m/Y');
        $pets->avistamentos = Avistamentos::select('*')->where('pet_id', $pets->id)->orderBy('created_at', 'DESC')->first();
        $pets->status = Status::select('*')->where('id', $pets->status_id)->first();
        $pets->times = $this->dates_differents->dateFormat($pets->created_at);
        $pets->user = Auth::user();

        return response()->json($pets);
    }

    /**
     * @OA\Post(
     *      tags={"Pets"},
     *      path="/pets-store",
     *      summary="Cadastrar pet",
     *      description="Retorna dados do pet",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="sex", type="string"),
     *                 @OA\Property(property="species", type="string"),
     *                 @OA\Property(property="breed", type="string"),
     *                 @OA\Property(property="size", type="string"),
     *                 @OA\Property(property="predominant_color", type="string"),
     *                 @OA\Property(property="secondary_color", type="string"),
     *                 @OA\Property(property="date_disappearance", type="string"),
     *                 @OA\Property(property="last_seen", type="string"),
     *                 @OA\Property(property="photo", type="string"),
     *                 example={"name": "Thor", "sex": "M", "species": "Cachorro", "breed": "Vira Lata", "size": "Grande", "predominant_color": "Preto", "secondary_color": "Branco", "date_disappearance": "05/04/2022", "last_seen": "Rua teste", "photo": "teste123"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     * @throws Exception
     */
    public function petsStore(Request $request): JsonResponse
    {
        $dados = $request->all();

        $validator = Validator::make($dados, [
            'nome' => ['required'],
            'sexo' => ['required'],
            'foto' => ['required'],
            'especie' => ['required'],
            'raca' => ['required'],
            'tamanho' => ['required'],
            'cor_predominante' => ['required'],
            'data_desaparecimento' => ['required'],
            'ultima_vez_visto' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        
        $dados['foto'] = UploadFileS3::upload($request, 3);
        $dados['user_id'] = Auth::user()->id;
        $dados['status_id'] = 1;
        
        
        // dd($dados);

        $pet = Pets::create($dados);

        $pet->avistamentos()->create([
            'ultima_vez_visto' => $dados['ultima_vez_visto'],
            'data_avistamento' => $dados['data_desaparecimento'],
            'esta_com_pet' => 0,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json(['success' => 'Cadastro efetuado com sucesso!']);
    }
}
