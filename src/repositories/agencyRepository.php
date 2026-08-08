<?php

namespace App\Agency;

use App\Agency\AgencyModel;
use InvalidArgumentException;
use App\Database\ConnectDatabase;
use PDO;

class AgencyRepository
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::connect();
    }

    private function mapRowToAgency(array $row): ?AgencyModel
    {
        return new AgencyModel(
            id: (int)$row['agency_Id'],
            name: $row['agency_Name']
        );
    }

    private function getCreatedAgency(string $name)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE agency_Name = :name");
        $stmt->execute(['name' => $name]);

        $agency = $stmt->fetch();

        if (!$agency) {
            return null;
        }

        return $this->mapRowToAgency($agency);
    }

    public function createAgency(string $name): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO agencies (agency_Name) VALUES (:name)");
        return $stmt->execute(['name' => $name]);
    }

    public function getAllAgencies(): ?array
    {
        $stmt = $this->pdo->query("SELECT * FROM agencies");

        $rows = $stmt->fetchAll();

        if (!$rows) {
            return null;
        }
        foreach ($rows as $row) {
            $agencies[] = $this->mapRowToAgency($row);
        }

        return $agencies;
    }

    public function getAgencyById(int $id): ?AgencyModel
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE agency_Id = :id 
        ORDER BY agency_Name");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return $this->mapRowToAgency($row);
    }

    public function getAgencyByName(string $name): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE agency_Name LIKE '%':name'%' 
        ORDER BY agnecy_Name");
        $stmt->execute(['name' => $name]);

        $rows = $stmt->fetchAll();

        if (!$rows) {
            return null;
        }
        foreach ($rows as $row) {
            $agencies[] = $this->mapRowToAgency($row);
        }

        return $agencies;
    }

    public function updateAgency(int $id, string $name): bool
    {
        $stmt = $this->pdo->prepare('UPDATE agencies SET agency_Name = ":name" 
        WHERE agency_Id = ":id" ');
        $stmt->execute(['name' => $name, 'id' => $id]);

        return $stmt->rowcount() > 0;
    }

    public function deleteAgency(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM agencies WHERE agency_Id = :id ");
        $stmt->execute(['id' => $id]);

        return $stmt->rowcount() > 0;
    }
}
