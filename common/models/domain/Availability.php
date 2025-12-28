<?php

namespace app\common\models\domain;

use InvalidArgumentException;

class Availability
{
    private int $id;
    /** @var int ID do profissional dono da disponibilidade */
    private int $professionalId;
    /** @var string[] Lista de horários disponíveis */
    private array $availability;

    public function __construct(int $id, int $professionalId, array $availability = [])
    {
        $this->validateProfessionalId($professionalId);
        $this->validateAvailability($availability);

        $this->id = $id;
        $this->professionalId = $professionalId;
        $this->availability = $availability;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProfessionalId(): int
    {
        return $this->professionalId;
    }

    public function getAvailability(): array
    {
        return $this->availability;
    }

    // Validadores

    private function validateProfessionalId(int $professionalId): void
    {
        if ($professionalId <= 0) {
            throw new InvalidArgumentException("Professional ID must be greater than zero.");
        }
    }

    private function validateAvailability(array $availability): void
    {
        if (empty($availability)) {
            throw new InvalidArgumentException("Availability cannot be empty.");
        }
    }
}
