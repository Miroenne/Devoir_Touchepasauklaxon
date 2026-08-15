<?php

namespace App\Repositories;

use App\Models\TripModel;
use App\Db\ConnectDatabase;
use DateTimeImmutable;
use PDO;

class TripRepository
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::connect();
    }

    private function mapRowToTrip(array $row): ?TripModel
    {

        return new TripModel(
            id: (int) $row['trip_Id'],
            departureDateTime: new DateTimeImmutable($row['trip_DepartureDateTime']),
            arrivalDateTime: new DateTimeImmutable($row['trip_ArrivalDateTime']),
            space: (int) $row['trip_Space'],
            creatorUserId: (int) $row['trip_CreatorUserId'],
            departureAgencyId: (int) $row['trip_DepartureAgencyId'],
            arrivalAgencyId: (int) $row['trip_ArrivalAgencyId'],
        );
    }

    public function createTrip(
        DateTimeImmutable $departureDateTime,
        DateTimeImmutable $arrivalDateTime,
        int $space,
        int $creatorUserId,
        int $departureAgencyId,
        int $arrivalAgencyId
    ) {
        $formattedDepartureDateTime = $departureDateTime->format('Y-m-d H:i:s');
        $formattedArrivalDateTime = $arrivalDateTime->format('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO trips (
            trip_DepartureDateTime, trip_ArrivalDateTime,
            trip_Space, trip_CreatorUserId,
            trip_DepartureAgencyId, trip_ArrivalAgencyId
            ) VALUES (
            :departureDateTime, :arrivalDateTime,
            :space, :creatorUserId,
            :departureAgencyId, :arrivalAgencyId
            )");

        return $stmt->execute([
            'departureDateTime' => $formattedDepartureDateTime,
            'arrivalDateTime' => $formattedArrivalDateTime,
            'space' => $space,
            'creatorUserId' => $creatorUserId,
            'departureAgencyId' => $departureAgencyId,
            'arrivalAgencyId' => $arrivalAgencyId
        ]);
    }

    public function getAllTrips(): ?array
    {

        $stmt = $this->pdo->query("SELECT * FROM trips");

        $rows = $stmt->fetchAll();

        if (!$rows) {
            return null;
        }

        foreach ($rows as $row) {

            $trips[] = $this->mapRowToTrip($row);
        }
        return $trips;
    }

    public function getTripById(int $id)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM trips WHERE trip_Id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return $this->mapRowToTrip($row);
    }

    public function getAllActualTrips(DateTimeImmutable $date)
    {
        $date = $date->format('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare("SELECT * FROM trips WHERE trip_DepartureDateTime > :date AND trip_Space > 0");
        $stmt->execute(['date' => $date]);

        $rows = $stmt->fetchAll();

        if (!$rows) {
            return null;
        }
        foreach ($rows as $row) {
            $trips[] = $this->mapRowToTrip($row);
        }
        return $trips;
    }

    public function updateTrip(
        int $id,
        DateTimeImmutable $departureDateTime,
        DateTimeImmutable $arrivalDateTime,
        int $space,
        int $departureAgencyId,
        int $arrivalAgencyId
    ) {
        $stmt = $this->pdo->prepare("UPDATE trips SET 
            trip_DepartureDateTime = :departureDateTime,
            trip_ArrivalDateTime = :arrivalDateTime,
            trip_Space = :space,
            trip_DepartureAgencyId = :departureAgencyId,
            trip_ArrivalAgencyId = :arrivalAgencyId
        ");

        $formattedDepartureDateTime = $departureDateTime->format('Y-m-d H:i:s');
        $formattedArrivalDateTime = $arrivalDateTime->format('Y-m-d H:i:s');

        $stmt->execute([
            'departureDateTime' => $formattedDepartureDateTime,
            'arrivalDateTime' => $formattedArrivalDateTime,
            'space' => $space,
            'departureAgencyId' => $departureAgencyId,
            'arrivalAgencyId' => $arrivalAgencyId
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deleteTrip(int $id)
    {

        $stmt = $this->pdo->prepare("DELETE FROM trips WHERE trip_Id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
