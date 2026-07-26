<?php

namespace App\Trip;

use DateTimeImmutable;

class TripModel{

    private ?int $id;
    private DateTimeImmutable $departureDateTime;
    private DateTimeImmutable $arrivalDateTime;
    private int $space;
    private int $creatorUserId;
    private int $departureAgencyId;
    private int $arrivalAgencyId;

    public function __construct(?int $id, DateTimeImmutable $departureDateTime,
    DateTimeImmutable $arrivalDateTime, int $space, int $creatorUserId,
    int $departureAgencyId, int $arrivalAgencyId){
        $this->id = $id;
        $this->departureDateTime = $departureDateTime;
        $this->arrivalDateTime = $arrivalDateTime;
        $this->space = $space;
        $this->creatorUserId = $creatorUserId;
        $this->departureAgencyId = $departureAgencyId;
        $this->arrivalAgencyId = $arrivalAgencyId;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getDepartureDateTime(): DateTimeImmutable {
        return $this->departureDateTime;
    }

    public function getArrivalDateTime(): DateTimeImmutable {
        return $this->arrivalDateTime;
    }

    public function getSpace(): int {
        return $this->space;
    }

    public function getCreatorUserId(): int {
        return $this->creatorUserId;
    }

    public function getDepartureAgencyId(): int {
        return $this->departureAgencyId;
    }

    public function getArrivalAgencyId(): int {
        return $this->arrivalAgencyId;
    }


    public function setDepartureDateTime(DateTimeImmutable $departureDateTime): void {
        $this->departureDateTime = $departureDateTime;
    }

    public function setArrivalDateTime(DateTimeImmutable $arrivalDateTime): void {
        $this->arrivalDateTime = $arrivalDateTime;
    }

    public function setSpace(int $space): void {
        $this->space = $space;
    }

    public function setCreatorUserId(int $creatorUserId): void {
        $this->creatorUserId = $creatorUserId;
    }

    public function setDepartureAgencyId(int $departureAgencyId): void {
        $this->departureAgencyId = $departureAgencyId;
    }

    public function setArrivalAgencyId(int $arrivalAgencyId): void {
        $this->arrivalAgencyId = $arrivalAgencyId;
    }
}