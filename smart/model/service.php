<?php

class Service 
{
    private int $serviceId;
    private string $name;
    private string $description;
    private int $serviceTypeId;

    public function __construct(int $serviceId, string $name, string $description, int $serviceTypeId) 
    {
        $this->serviceId = $serviceId;
        $this->name = $name;
        $this->description = $description;
        $this->serviceTypeId = $serviceTypeId;
    }

    public function getServiceId(): int { return $this->serviceId; }
    public function setServiceId(int $serviceId): void { $this->serviceId = $serviceId; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getServiceTypeId(): int { return $this->serviceTypeId; }
    public function setServiceTypeId(int $serviceTypeId): void { $this->serviceTypeId = $serviceTypeId; }
}

?>