<?php

namespace App\Controllers;

use App\Services\TripServices;
use App\Repositories\TripRepository;
use App\Utils\InvalidCredentialsException;
use App\Utils\DomainException;
use InvalidArgumentException;
use RuntimeException;
use App\Utils\ExceptionSerialize;
use DateTimeImmutable;


class TripControllers
{

    public function __construct(private TripServices $service, private ExceptionSerialize $serialize) {}

    public static function create(): self
    {
        return new self(new TripServices(new TripRepository()), new ExceptionSerialize());
    }

    public function createTripController(
        DateTimeImmutable $departureDateTime,
        DateTimeImmutable $arrivalDateTime,
        int $space,
        int $creatorUserId,
        int $departureAgencyId,
        int $arrivalAgencyId
    ) {

        if (isset($_SESSION['id'])) {

            try {
                $newTrip = $this->service->createTripService(
                    $departureDateTime,
                    $arrivalDateTime,
                    $space,
                    $creatorUserId,
                    $departureAgencyId,
                    $arrivalAgencyId
                );

                if ($newTrip) {
                    $result = [
                        'message' => 'Trajet créé avec succès',
                        'responseCode' => 201
                    ];

                    return $result = json_encode($result);
                }
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 500);
            }
        } else {
        }
    }
}
