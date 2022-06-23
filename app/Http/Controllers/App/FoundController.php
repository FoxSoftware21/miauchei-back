<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Pets;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class FoundController extends Controller
{

    /**
     * @OA\Put(
     *      tags={"Pets"},
     *      path="/pet-found/{id}",
     *      summary="Pet encontrado",
     *      description="Atualização do pet para encontrado",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          description="ID do pet",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\RequestBody(@OA\MediaType(mediaType="application/json")),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function petFound($id): JsonResponse
    {
        $pet = Pets::findOrFail($id);
        $pet->status_id = 2;
        $pet->data_desaparecimento = Carbon::now()->format('Y-m-d');
        $pet->save();

        return response()->json(['success' => 'Atualização efetuada com sucesso!']);
    }
}
