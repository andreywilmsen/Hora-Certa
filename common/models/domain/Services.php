<?php

namespace app\common\models\domain;

use InvalidArgumentException;

class Service
{
    private int $id;
    private string $serviceName;
    private int $lengthService;

    public function __construct(int $id, string $serviceName, int $lengthService)
    {
        $this->validateServiceName($serviceName);
        $this->validateLengthService($lengthService);

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

    // Validadores

    private function validateServiceName(string $serviceName): void
    {
        if (empty($serviceName)) {
            throw new InvalidArgumentException("Service name cannot be empty.");
        }
    }

    private function validateLengthService(int $lengthService): void
    {
        if (empty($lengthService)) {
            throw new InvalidArgumentException("Length service cannot be empty.");
        }
    }
}
