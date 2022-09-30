<?php
namespace App\Classes\Helpers;


use App\Interfaces\HelperInterface;
use App\Models\Warehouse\Auto;
use Nette\Utils\Json;

class PalletsHelper implements HelperInterface
{
    /**
     * @param Auto $model
     * @return mixed
     * @throws \Nette\Utils\JsonException
     */
    public function getAutosWithFullPallets(Auto $model)
    {
        $flights = $model::whereNotNull(Auto::A_PALLETSINFORMATION)
            ->get();

        foreach ($flights as $flight) {
            $flight[Auto::A_PALLETSINFORMATION] = Json::decode($flight->{Auto::A_PALLETSINFORMATION}, Json::FORCE_ARRAY);
        }

        return $flights;
    }
}
