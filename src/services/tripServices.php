<?php

namespace App\Trip;

use App\Exception\InvalidCredentialsException;
use App\Exception\DomainException;
use InvalidArgumentException;
use App\Trip\TripModel;
use DateTimeImmutable;
use App\Agency\AgencyControllers;
use App\Agency\AgencyServices;
use App\Agency\AgencyRepository;
use App\Exception\Serialized;
use App\User\UserRepository;
use App\User\UserServices;
use App\User\UserControllers;
use RuntimeException;

class TripService
{

    private TripModel $model;
    private AgencyControllers $agencyController;
    private UserControllers $userController;

    public function __construct(private TripRepository $repository)
    {
        $this->agencyController = new AgencyControllers(new AgencyServices(new AgencyRepository), new Serialized());
        $this->userController = new UserControllers(new UserServices(new UserRepository), new Serialized());
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

        return $trip = $this->repository->createTrip(
            $departureDateTime,
            $arrivalDateTime,
            $space,
            $creatorUserId,
            $departureAgencyId,
            $arrivalAgencyId
        );
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

    private function assertCreator(int $id, int $updateUserId, bool $admin, string $message): void
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


        $this->assertCreator($id, $creatorUserId, $admin, $message);

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

        $this->assertCreator($id, $userId, $admin, $message);

        $deleteTrip = $this->repository->deleteTrip($id);

        if (!$deleteTrip) {
            throw new DomainException('Trip not found');
        }

        return $deleteTrip;
    }
}
