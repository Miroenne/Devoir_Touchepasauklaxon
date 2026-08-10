<?php

namespace App\Agency;

use App\Agency\AgencyServices;
use App\Exception\DomainException;
use App\Exception\InvalidCredentialsException;
use App\Exception\Serialized;
use JsonSerializable;

class AgencyControllers
{

    public function __construct(private AgencyServices $services, private Serialized $serialize) {}

    public static function create(): self
    {
        return new self(new AgencyServices(new AgencyRepository()), new Serialized());
    }

    public function createAgencyController(string $name)
    {

        if ($_SESSION['admin']) {
            try {
                $agency = $this->services->createAgencyService($name);

                if ($agency) {
                    return ['agency' => 'created', 'responseCode' => 200];
                }
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 500);
            }
        } else {
            $error = [
                'message' => 'Only administrators can create an agency',
                'responseCode' => 403
            ];
            return $error;
        }
    }

    public function getAllAgenciesController()
    {

        if (!empty($_SESSION['id'])) {
            try {
                $agencies = $this->services->getAllAgenciesService();

                foreach ($agencies as $agency) {
                    $json = json_encode($agency);

                    $jsonAgencies[] = $json;
                }

                return $jsonAgencies;
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 404);
            }
        } else {
            return $error = [
                'message' => 'Credentials required',
                'responseCode' => 403
            ];
        }
    }

    public function getAgencyByIdController(int $id)
    {
        if (!empty($_SESSION['id'])) {
            try {
                $agency = $this->services->getAgencyByIdService($id);

                $agency = json_encode($agency);
                return $agency;
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 404);
            }
        } else {
            return $error = [
                'message' => 'Credentials required',
                'responseCode' => 403
            ];
        }
    }

    public function getAgencyByNameController(string $name)
    {
        if (!empty($_SESSION['id'])) {
            try {
                $agencies = $this->services->getAgencyByNameService($name);
                foreach ($agencies as $agency) {
                    $json = json_encode($agency);
                    $jsonAgencies[] = $json;
                }

                return $jsonAgencies;
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 404);
            }
        } else {
            return $error = [
                'message' => 'Credentials required',
                'responseCode' => 403
            ];
        }
    }

    public function updateAgencyController(int $id, string $name)
    {

        if (!empty($_SESSION['admin']) && $_SESSION['admin'] === true) {
            try {
                $agency = $this->services->updateAgencyService($id, $name);

                $agency = json_encode($agency);
                return $agency;
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 404);
            }
        } else {
            return $error = [
                'message' => 'Only administrators can update an agency',
                'responseCode' => 403
            ];
        }
    }

    public function deleteAgencyController(int $id)
    {

        if (!empty($_SESSION['admin']) && $_SESSION['admin'] === true) {
            try {
                $agency = $this->services->deleteAgencyService($id);

                $agency = json_encode($agency);
                return $agency;
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 404);
            }
        } else {
            return $error = [
                'message' => 'Only administrators can delete an agency',
                'responseCode' => 403
            ];
        }
    }
}
