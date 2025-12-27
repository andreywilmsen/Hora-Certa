<?php

namespace app\common\models\domain;

class Profesisonal
{
    private int $id;
    private string $name;
    /** @var string[] Lista de serviços por profissional  */
    private array $services = [];
    /** @var string[] Lista de horários disponíveis por profissional */
    private array $availabillity = [];

    public function __construct(int $id, string $name, array $services = [], array $availabillity = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->services = $services;
        $this->availabillity = $availabillity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    public function getAvailabillity(): array
    {
        return $this->availabillity;
    }
}
