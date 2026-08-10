<?php
session_start();

use App\Exception\Serialized;
use App\Agency\AgencyControllers;
use App\Agency\AgencyServices;
use App\Agency\AgencyRepository;

$agencyController = new AgencyControllers(new AgencyServices(new AgencyRepository), new Serialized());

$newAgency = $agencyController->updateAgencyController(9, 'Cannes');
var_dump($newAgency);
echo '<br>';

if (isset($newAgency['responseCode']) !== 200) {

    echo "Message d'erreur : " . $newAgency['message'] . '<br>';
    echo "Code erreur : " . $newAgency['responseCode'] . '<br>';
}
$agencies = $agencyController->getAgencyByNameController('ant');

if ($agencies) {

    foreach ($agencies as $agency) {
        $agency = json_decode($agency);

        echo 'Agence ID : ' . $agency->id . '<br>';
        echo 'Nom agence : ' . $agency->name . '<br>';
    }
}
