<?php

namespace app\common\models\domain;

class Service
{
    private int $id;
    private string $serviceName;
    private int $lengthService;

    public function __construct(int $id, string $serviceName, int $lengthService)
    {
        $this->id = $id;
        $this->serviceName = $serviceName;
        $this->lengthService = $lengthService;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getLengthService(): int
    {
        return $this->lengthService;
    }
}
