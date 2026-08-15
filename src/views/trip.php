<?php

session_start();

use App\Utils\ExceptionSerialize;
use App\Controllers\TripControllers;
use App\Services\TripServices;
use App\Repositories\TripRepository;
use App\Controllers\AgencyControllers;
use App\Services\AgencyServices;
use App\Repositories\AgencyRepository;

$agencyController = new AgencyControllers(new AgencyServices(new AgencyRepository), new ExceptionSerialize());
$tripController = new TripRepository();

$_SESSION['id'] = 1;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon - Trip form</title>
</head>

<body>
    <header></header>
    <main>
        <form method='POST'>
            <label for="departureDateTime">Date et heure de départ</label>
            <input type="datetime-local" name='departureDateTime' id='departureDateTime'>
            <label for="arrivalDateTime">Date et heure d'arrivée</label>
            <input type="datetime-local" name='arrivalDateTime' id='arrivalDateTime'>
            <label for="space">Places disponibles</label>
            <input list='spaces' name='space' id='space'>
            <datalist id='spaces'>
                <option value=0></option>
                <option value=1></option>
                <option value=2></option>
                <option value=3></option>
                <option value=4></option>
            </datalist>
            <input type="hidden" name='creatorUserId' id='creatorUserId'
                value=<?php echo $_SESSION['id'] ?>>
            <label for="departureAgencyId">Agence de départ</label>
            <input list='agencies' name='departureAgencyId' id='departureAgencyId'>
            <label for="arrivalAgencyId">Agence d'arrivée</label>
            <input list='agencies' name='arrivalAgencyId' id='arrivalAgencyId'>
            <input type="submit" value="Valider">
            <datalist id='agencies'>
                <?php
                $agencies = $agencyController->getAllAgenciesController();
                var_dump($agencies);
                if ($agencies) {
                    foreach ($agencies as $agency) {
                        $agency = json_decode($agency);
                ?>

                        <option value=<?php echo $agency->name ?>></option>
                <?php
                    }
                }
                ?>
            </datalist>

            <!--<fieldset>
                <legend>Agence de départ :</legend>
                <?php
                $agencies = $agencyController->getAllAgenciesController();

                if ($agencies) {

                    foreach ($agencies as $agency) {
                        $agency = json_decode($agency);
                        $name = $agency->name . 'agency';
                ?>
                        <div>
                            <input type="radio" id=<?php echo $agency->name ?>
                                name=<?php echo $name ?> value=<?php echo $agency->id ?>>
                            <label for=<?php echo $agency->name ?>><?php echo $agency->name ?></label>
                        </div>


                <?php
                    }
                }
                ?>
            </fieldset>-->

        </form>
    </main>
    <footer></footer>
</body>

</html>