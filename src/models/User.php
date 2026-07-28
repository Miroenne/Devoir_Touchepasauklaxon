<?php

namespace App\User;

use InvalidArgumentException;
use JsonSerializable;

class UserModel implements JsonSerializable {

    private readonly ?int $id;
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;
    private string $email;
    private string $passwordHash;
    private bool $admin;
    
    public function __construct(?int $id,string $firstName,string $lastName, 
    string $phoneNumber,string $email,string $passwordHash,bool $admin){
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->admin = $admin;
    }

    public function jsonSerialize(): array{
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'admin' => $this->admin
        ];
    }    

    public function getId(): ?int {
        return $this->id;
    }
    
    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPasswordHash():string {
        return $this->passwordHash;
    }

    public function getAdmin(): bool {
        return $this->admin;
    }

    public function setId(int $id):void{
        $this->id = $id;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function setPhoneNumber(string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $passwordHash): void {
        $this->passwordHash = $passwordHash;
    }

    public function setAdmin(bool $admin): void {
        $this->admin = $admin;
    }

    public function assertPassword(string $plainPassword): bool {        
        return password_verify($plainPassword, $this->passwordHash);
    }
}