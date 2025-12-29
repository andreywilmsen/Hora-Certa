<?php

namespace app\modules\user\domain\entities;

use InvalidArgumentException;

class User
{
    private int $id;
    private string $userName;
    private string $firstName;
    private string $lastName;
    private string $email;

    public function __construct(int $id, string $userName, string $firstName, string $lastName, string $email)
    {
        $this->validateUserName($userName);
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateEmail($email);

        $this->id = $id;
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getFirstName(): string
    {
        return  $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    // Validadores

    private function validateUserName(string $userName): void
    {
        if (empty($userName)) {
            throw new InvalidArgumentException("Username cannot be empty.");
        }
    }

    private function validateFirstName(string $firstName): void
    {
        if (empty($firstName)) {
            throw new InvalidArgumentException("First name cannot be empty.");
        }
    }

    private function validateLastName(string $lastName): void
    {
        if (empty($lastName)) {
            throw new InvalidArgumentException("Last name cannot be empty.");
        }
    }

    private function validateEmail(string $email): void
    {
        if (empty($email)) {
            throw new InvalidArgumentException("Email cannot be empty.");
        }
    }
}
