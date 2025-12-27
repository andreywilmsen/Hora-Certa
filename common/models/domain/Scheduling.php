<?php

namespace app\common\models\domain;

class Scheduling
{
    private int $id;
    /** @var int ID do profissional que foi agendado */
    private int $professionalId;
    /** @var int[] Lista de serviços agendados */
    private array $servicesId;
    /** @var float Tempo total do agendamento (somatória dos serviços) */
    private int $lengthServices;
    /** @var \DateTimeImmutable Dia do agendamento */
    private \DateTimeImmutable $date;
    /** @var int ID do cliente que agendou */
    private int $clientId;
    /** @var float Valor total do serviço */
    private float $value;
    /** @var string Status do agendamento (Compareceu, Faltou, Reagendou...) */
    private string $status;


    public function __construct(int $id, int $professionalId, array $servicesId = [], int $lengthServices, \DateTimeImmutable $date, int $clientId, float $value, string $status)
    {
        $this->id = $id;
        $this->professionalId = $professionalId;
        $this->servicesId = $servicesId;
        $this->lengthServices = $lengthServices;
        $this->date = $date;
        $this->clientId = $clientId;
        $this->value = $value;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProfessionalId(): int
    {
        return $this->professionalId;
    }

    public function getServices(): array
    {
        return $this->servicesId;
    }

    public function getLengthServices(): int
    {
        return $this->lengthServices;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getStatus(): string{
        return $this->status;
    }
}