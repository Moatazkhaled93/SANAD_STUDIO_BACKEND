<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="SANAD Studio API",
 *     version="1.0.0",
 *     description="API documentation for SANAD Studio Backend",
 *     @OA\Contact(
 *         email="support@sanadstudio.com"
 *     )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="passport",
 *     type="oauth2",
 *     @OA\Flow(
 *         flow="password",
 *         tokenUrl="/oauth/token",
 *         scopes={}
 *     )
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 */
abstract class Controller
{
    //
}
