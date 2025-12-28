<?php

namespace app\common\models\domain;

use InvalidArgumentException;

class Customer
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $phone;

    public function __construct(int $id, string $firstName, string $lastName, string $phone)
    {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validatePhone($phone);

        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getPhone(): string
    {
        return $this->phone;
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

    private function validatePhone(string $phone): void
    {
        if (!preg_match('/^\+?\d{8,15}$/', $phone)) {
            throw new InvalidArgumentException("Phone number is invalid.");
        }
    }
}
