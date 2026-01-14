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
    private ?string $passwordResetToken;
    private ?int $passwordResetExpiresAt;

    public function __construct(string $userName, string $firstName, string $lastName, string $email, string $passwordHash, ?string $passwordResetToken = null, ?int $passwordResetExpiresAt = null)
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
        $this->passwordResetToken = $passwordResetToken;
        $this->passwordResetExpiresAt = $passwordResetExpiresAt;
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

    // Resetar senha

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(string $token, int $expiresInSeconds = 3600): void
    {
        $this->passwordResetToken = $token;
        $this->passwordResetExpiresAt = time() + $expiresInSeconds;
    }

    public function getPasswordExpiresAt(): ?string{
        return $this->passwordResetExpiresAt;
    }

    public function isResetTokenValid(string $tokenForValidation): bool
    {
        if ($this->passwordResetToken !== $tokenForValidation) {
            return false;
        }

        return $this->passwordResetExpiresAt > time();
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
