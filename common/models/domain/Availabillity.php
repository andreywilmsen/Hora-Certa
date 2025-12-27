<?php

namespace app\common\models\domain;

class Availability{
    private int $id;
    /** @var int ID do profissional dono da disponibilidade */
    private int $professionalId;
    /** @var string[] Lista de horários disponíveis */
    private array $availability;

    public function __construct(int $id, int $professionalId, array $availability = [])
    {
        $this->id = $id;
        $this->professionalId = $professionalId;
        $this->availability = $availability;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getProfessionalId(): int {
        return $this->professionalId;
    }

    public function getAvailability():array{
        return $this->availability;
    }
}