<?php

namespace App\Services;

use App\Utils\InvalidCredentialsException;
use App\Utils\DomainException;
use InvalidArgumentException;
use App\Models\TripModel;
use App\Repositories\TripRepository;
use DateTimeImmutable;
use App\Controllers\AgencyControllers;
use App\Services\AgencyServices;
use App\Repositories\AgencyRepository;
use App\Utils\ExceptionSerialize;
use App\Repositories\UserRepository;
use App\Services\UserServices;
use App\Controllers\UserControllers;
use RuntimeException;

class TripServices
{

    private TripModel $model;
    private AgencyControllers $agencyController;
    private UserControllers $userController;

    public function __construct(private TripRepository $repository)
    {
        $this->agencyController = new AgencyControllers(new AgencyServices(new AgencyRepository), new ExceptionSerialize());
        $this->userController = new UserControllers(new UserServices(new UserRepository), new ExceptionSerialize());
    }

    public function createTripService(
        DateTimeImmutable $departureDateTime,
        DateTimeImmutable $arrivalDateTime,
        int $space,
        int $creatorUserId,
        int $departureAgencyId,
        int $arrivalAgencyId
    ) {

        $model = new TripModel(
            null,
            $departureDateTime,
            $arrivalDateTime,
            $space,
            $creatorUserId,
            $departureAgencyId,
            $arrivalAgencyId
        );

        $model->assertDateTime($departureDateTime, $arrivalDateTime);
        $model->assertAgencies($departureAgencyId, $arrivalAgencyId);

        $this->existingAgency($departureAgencyId);
        $this->existingAgency($arrivalAgencyId);

        $model->assertSpace($space);

        $trip = $this->repository->createTrip(
            $departureDateTime,
            $arrivalDateTime,
            $space,
            $creatorUserId,
            $departureAgencyId,
            $arrivalAgencyId
        );

        if (!$trip) {
            throw new DomainException('Trip cannot been created');
        }

        return $trip;
    }

    private function existingAgency(int $id): void
    {
        $existingAgency = $this->agencyController->getAgencyByIdController($id);

        if (isset($existingAgency['responseCode'])) {
            if ($existingAgency['responseCode'] === 404) {
                throw new DomainException($existingAgency["message"]);
            } elseif ($existingAgency['responseCode'] === 403) {
                throw new InvalidCredentialsException($existingAgency["message"]);
            }
        }
    }

    private function assertUser(int $id, int $updateUserId, bool $admin, string $message): void
    {
        $updateTrip = $this->repository->getTripById($id);

        if ($updateTrip) {

            $tripCreatorId = $updateTrip->getCreatorUserId();

            if ($tripCreatorId !== $updateUserId) {
                if (!$admin) {
                    throw new RuntimeException($message);
                }
            }
        }
    }

    public function getAllTripsService()
    {
        $trips = $this->repository->getAllTrips();

        if ($trips === null) {
            throw new DomainException('No trip found');
        }

        return $trips;
    }

    public function getAllActualTripsService(DateTimeImmutable $date)
    {
        $trips = $this->repository->getAllActualTrips($date);

        if ($trips === null) {
            throw new DomainException('No actual trip found');
        }

        return $trips;
    }

    public function getTripByIdService(int $id)
    {
        $trip = $this->repository->getTripById($id);

        if ($trip === null) {
            throw new DomainException('Trip not found');
        }

        return $trip;
    }

    public function updateTripService(
        int $id,
        DateTimeImmutable $departureDateTime,
        DateTimeImmutable $arrivalDateTime,
        int $space,
        int $creatorUserId,
        int $departureAgencyId,
        int $arrivalAgencyId
    ) {

        $json = $this->userController->getUserByIdController($creatorUserId);
        $user = json_decode($json);

        $admin = $user->admin;

        $message = 'Only the creator of this trip or an admin can update it';


        $this->assertUser($id, $creatorUserId, $admin, $message);

        $model = new TripModel(
            null,
            $departureDateTime,
            $arrivalDateTime,
            $space,
            $creatorUserId,
            $departureAgencyId,
            $arrivalAgencyId
        );

        $model->assertDateTime($departureDateTime, $arrivalDateTime);
        $model->assertAgencies($departureAgencyId, $arrivalAgencyId);

        $this->existingAgency($departureAgencyId);
        $this->existingAgency($arrivalAgencyId);

        $model->assertSpace($space);

        $updateTrip = $this->repository->updateTrip(
            $id,
            $departureDateTime,
            $arrivalDateTime,
            $space,
            $departureAgencyId,
            $arrivalAgencyId
        );

        if (!$updateTrip) {
            throw new DomainException('Trip not found');
        }

        return $updateTrip;
    }

    public function deleteTripService(int $id, int $userId)
    {

        $json = $this->userController->getUserByIdController($userId);
        if ($json) {
            $user = json_decode($json);

            $admin = $user->admin;
        }

        $message = 'Only the creator of this trip or an admin can delete it';

        $this->assertUser($id, $userId, $admin, $message);

        $deleteTrip = $this->repository->deleteTrip($id);

        if (!$deleteTrip) {
            throw new DomainException('Trip not found');
        }

        return $deleteTrip;
    }
}
