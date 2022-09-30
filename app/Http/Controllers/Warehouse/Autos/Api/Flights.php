<?php

namespace App\Http\Controllers\Warehouse\Autos\Api;

use App\Classes\Constants\Pallets;
use App\Classes\Helpers\DateTimeHelper;
use App\Classes\Helpers\PalletsHelper;
use App\Http\Controllers\Controller;
use App\Models\Warehouse\Auto;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use OpenApi\Annotations as OA;
use App\Classes\SwaggerDocs\FinalSum;

class Flights extends Controller
{
    use JsonResponseTrait;

    /**
     * @var Auto
     */
    protected Auto $auto;

    /**
     * @var PalletsHelper
     */
    protected PalletsHelper $palletsHelper;

    /**
     * @var DateTimeHelper
     */
    protected DateTimeHelper $dateTimeHelper;

    /**
     * Flights constructor.
     * @param Auto $auto
     * @param PalletsHelper $palletsHelper
     * @param DateTimeHelper $dateTimeHelper
     */
    public function __construct(
        Auto $auto,
        PalletsHelper $palletsHelper,
        DateTimeHelper $dateTimeHelper
    )
    {
        $this->auto = $auto;
        $this->palletsHelper = $palletsHelper;
        $this->dateTimeHelper = $dateTimeHelper;
    }

    /**
     * @OA\Get(
     *     path="/flights/pallets",
     *     description="Get all pallets",
     *     tags={"Flights"},
     *     operationId="All pallets",
     *     @OA\Response(
     *          response=200,
     *          description="Success Answer",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="message", type="string", example=""),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Auto"))
     *          )
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Nette\Utils\JsonException
     */
    public function getWithPallets(Request $request)
    {
        $flights = $this->palletsHelper->getAutosWithFullPallets($this->auto);

        $finished = [];
        foreach ($flights as $flight) {
            $type = Pallets::TYPE_CAR;
            $name = "";
            $pallets = 0;

            $actualDate = $this->dateTimeHelper
                ->getDateTimeFromTimestamp($flight->A_STARTTIME);

            //если время создания машины меньше чем 4 утра - то от даты минусуем один день
            if ((integer) $actualDate->format("h") <= 4 ) {
                $actualDate = $actualDate->modify("-1 day");
            }

            //достаём первый ключ массива с инфой о паллетах - это временная метка старта машины
            $startTime = array_key_first($flight->{Auto::A_PALLETSINFORMATION});

            foreach ($flight->{Auto::A_PALLETSINFORMATION} as $palletInformation) {
                if ($palletInformation[Pallets::ACTION] == Pallets::ACTION_END) {
                    $name = $palletInformation[Pallets::BADGE];
                    $type = Pallets::TYPE_PALLET;
                    //в некоторых случаях имеются два поля end с количество паллетов
                    $pallets += $palletInformation[Pallets::PALLETS];

                    if (isset($palletInformation[Pallets::SOTR_DOP])) {
                        foreach ($palletInformation[Pallets::SOTR_DOP] as $information) {
                            //в некоторых случаях количество паллетов хранится как строка,
                            //приводим её в число
                            $pallets = (integer) $information[Pallets::PALLETS];
                        }
                    }
                }
            }

            $finished[] = [
                "id" => $flight->{Auto::A_ID},
                "name" => $name,
                "type" => $type,
                "pallets" => $pallets,
                "start_time" => $startTime,
                "actual_date" => $actualDate->format(DateTimeHelper::FORMAT_YMD)
            ];
        }

        //формируем JSON ответ сервера
        return $this->success("", $finished);
    }

    /**
     * @OA\Get(
     *     path="/flights/final",
     *     description="Get final sum",
     *     tags={"Flights"},
     *     operationId="Final sum",
     *     @OA\Response(
     *          response=200,
     *          description="Success Answer",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="message", type="string", example=""),
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/FinalSum"))
     *          )
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Nette\Utils\JsonException
     */
    public function finalSum(Request $request)
    {
        $flights = $this->palletsHelper->getAutosWithFullPallets($this->auto);

        $totalSum = [];

        foreach ($flights as $flight) {
            foreach ($flight->{Auto::A_PALLETSINFORMATION} as $pallet) {
                $nameId = $pallet[Pallets::BADGE];

                //формируем массив с сотрудниками их их статистикой
                if (isset($totalSum[$nameId])) {
                    //получаем количество паллетов у сотрудника
                    $totalPallets = $totalSum[$nameId]["pallets"];

                    //если есть массив с допущенными паллетами - то в сумму считаем их
                    if (isset($pallet[Pallets::SOTR_DOP])) {
                        foreach ($pallet[Pallets::SOTR_DOP] as $access) {
                            $totalPallets += (integer)$access[Pallets::PALLETS];
                        }
                    }
                    //если же допущенных паллетов нет - то проверяем, есть ли они вообще
                    //и если есть - то добавлям их в сумму
                    //но только в том случае, если нету допущенных, что бы в сумму не попадали вообще все паллеты
                    if (isset($pallet[Pallets::PALLETS]) && !isset($pallet[Pallets::SOTR_DOP])) {
                        $totalPallets += $pallet[Pallets::PALLETS];
                    }

                    //присваиваем новое число паллетов сотруднику
                    $totalSum[$nameId]["pallets"] = $totalPallets;

                    //так как количество машин - это по сути и есть запись в базе данных
                    //то, просто добавляем единицу к текущему счётчику машин
                    $totalSum[$nameId]["cars"]++;
                }
                //если такого массива нет - то создаём пустой
                else {
                    $totalSum[$nameId] = [
                        "name" => $nameId,
                        "cars" => 0,
                        "pallets" => 0
                    ];
                }
            }
        }
        //так как в качестве уникального индентификатора сотрудника используется его имя с бейджа в качестве ключа -
        //то перед выводом удаляем этот ключ
        $totalSum = array_values($totalSum);

        //формируем JSON ответ сервера
        return $this->success("", $totalSum);
    }
}
