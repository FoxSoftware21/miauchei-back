<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Aplicativo MiauChei", version="1.0.0")
 * @OA\Server(url=L5_SWAGGER_CONST_HOST, description="API Local")
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   in="header",
 *   name="bearerAuth",
 *   type="http",
 *   scheme="bearer"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
