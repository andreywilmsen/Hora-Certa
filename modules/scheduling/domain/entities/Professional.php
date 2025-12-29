<?php

namespace app\modules\scheduling\domain\entities;

use InvalidArgumentException;

class Professional
{
    private int $id;
    private string $firstName;
    private string $lastName;
    /** @var string[] Lista de serviços por profissional  */
    private array $services = [];
    /** @var string[] Lista de horários disponíveis por profissional */
    private array $availability = [];

    public function __construct(int $id, string $firstName, string $lastName, array $services = [], array $availability = [])
    {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);

        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->services = $services;
        $this->availability = $availability;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string{
        return $this->firstName;
    }

    public function getLastName(): string{
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    public function getAvailability(): array
    {
        return $this->availability;
    }

    // Validadores

    private function validateFirstName(string $firstName): void {
        if(empty($firstName)){
            throw new InvalidArgumentException("First name cannot be empty.");
        }
    }

    private function validateLastName(string $lastName): void {
        if(empty($lastName)){
            throw new InvalidArgumentException("Last name cannot be empty.");
        }
    }
}