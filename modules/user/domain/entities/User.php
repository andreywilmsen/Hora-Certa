<?php

namespace app\modules\user\domain\entities;

use InvalidArgumentException;

class User
{
    private ?int $id = null;
    private string $userName;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $passwordHash;

    public function __construct(string $userName, string $firstName, string $lastName, string $email, string $passwordHash)
    {
        $this->validateUserName($userName);
        $this->validatePasswordHash($passwordHash);
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateEmail($email);

        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        if ($this->id !== null) {
            throw new \LogicException("User already has an ID.");
        }

        $this->id = $id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
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

    public function updateUser(string $userName, string $firstName, string $lastName, string $email): void
    {
        $this->validateUserName($userName);
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateEmail($email);

        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    // Utilitários

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->userName,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'full_name' => $this->getFullName(),
            'email' => $this->email,
        ];
    }

    // Validadores

    private function validateUserName(string $userName): void
    {
        if (empty($userName)) {
            throw new InvalidArgumentException("Username cannot be empty.");
        }
    }

    private function validatePasswordHash(string $passwordHash): void
    {
        if (empty($passwordHash)) {
            throw new InvalidArgumentException("Password cannot be empty.");
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
