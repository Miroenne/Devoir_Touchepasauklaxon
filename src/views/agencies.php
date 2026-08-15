<?php
session_start();

use App\Utils\ExceptionSerialize;
use App\Controllers\AgencyControllers;
use App\Services\AgencyServices;
use App\Repositories\AgencyRepository;

$agencyController = new AgencyControllers(new AgencyServices(new AgencyRepository), new ExceptionSerialize());

/*$newAgency = $agencyController->updateAgencyController(9, 'Cannes');
var_dump($newAgency);
echo '<br>';

if (isset($newAgency['responseCode']) !== 200) {

    echo "Message d'erreur : " . $newAgency['message'] . '<br>';
    echo "Code erreur : " . $newAgency['responseCode'] . '<br>';
}*/
$agencies = $agencyController->getAllAgenciesController();

if ($agencies) {

    foreach ($agencies as $agency) {
        $agency = json_decode($agency);

        echo 'Agence ID : ' . $agency->id . '<br>';
        echo 'Nom agence : ' . $agency->name . '<br>';
    }
}
