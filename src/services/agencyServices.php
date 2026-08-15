<?php

namespace App\Services;

use App\Repositories\AgencyRepository;
use App\Utils\InvalidCredentialsException;
use InvalidArgumentException;
use App\Utils\DomainException;

class AgencyServices
{

    public function __construct(private AgencyRepository $repository) {}

    public function createAgencyService(string $name)
    {

        $newAgency = $this->repository->createAgency($name);

        if ($newAgency) {
            $agency = $this->repository->getAgencyByName($name);

            if ($agency) {
                return $agency;
            }
        } else {
            throw new DomainException("Agency cannot been created");
        }
    }

    public function getAllAgenciesService(): ?array
    {

        $agencies = $this->repository->getAllAgencies();

        if ($agencies === null) {
            throw new DomainException('No agency found');
        }

        return $agencies;
    }

    public function getAgencyByIdService(int $id)
    {

        $agency = $this->repository->getAgencyById($id);

        if ($agency) {
            return $agency;
        } else {
            throw new DomainException("Agency not found");
        }
    }

    public function getAgencyByNameService(string $name)
    {

        $agency = $this->repository->getAgencyByName($name);

        if ($agency) {
            return $agency;
        } else {
            throw new DomainException("Agency not found");
        }
    }

    public function updateAgencyService(int $id, string $name)
    {

        $agency = $this->repository->updateAgency($id, $name);

        if ($agency) {
            return true;
        } else {
            throw new DomainException("Agency cannot been updated");
        }
    }

    public function deleteAgencyService(int $id)
    {
        $agency = $this->repository->deleteAgency($id);

        if ($agency) {
            return true;
        } else {
            throw new DomainException('Agency cannot been deleted');
        }
    }
}
