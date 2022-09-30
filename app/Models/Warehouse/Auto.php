<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Auto",
 *     description="Auto model",
 *     @OA\Xml(
 *          name="Auto"
 *     ),
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="badge name"),
 *     @OA\Property(property="type", type="string", example="pallet"),
 *     @OA\Property(property="pallets", type="integer", example="0"),
 *     @OA\Property(property="start_time", type="integer", example="1662015831"),
 *     @OA\Property(property="actual_date", type="date", example="2022.09.01"),
 * )
 *
 * Class Auto
 * @package App\Models\Warehouse
 */
class Auto extends Model
{
    use HasFactory;

    /* fields name constants */
    const A_ID = "A_ID";
    const A_NOMER = "A_NOMER";
    const A_RACE = "A_RACE";
    const A_STARTTIME = "A_STARTTIME";
    const A_PALLETSINFORMATION = "A_PALLETSFORMATION";

    public $timestamps = false;

    protected $primaryKey = "A_ID";

    protected $fillable = [];
}
