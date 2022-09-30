<?php


namespace App\Classes\SwaggerDocs;


use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="FinalSum",
 *     description="Final Sum model",
 *     @OA\Xml(
 *          name="FinalSum"
 *     ),
 *     @OA\Property(property="name", type="string", example="badge name"),
 *     @OA\Property(property="cars", type="integer", example="0"),
 *     @OA\Property(property="pallets", type="integer", example="0"),
 * )
 *
 * Class FinalSum
 * @package App\Classes\SwaggerClasses
 */
class FinalSum
{

}
