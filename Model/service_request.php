<?php

class ServiceRequest 
{
    private int $requestId;
    private ?int $clientId;
    private string $customName;
    private string $customDescription;
    private int $workerCount;
    private string $location;
    private DateTime $dateNeeded;
    private DateTime $dateRequested;
    private string $status;

    public function __construct
    (
        int $requestId, 
        int $clientId, 
        ?string $customName, 
        ?string $customDescription, 
        int $workerCount, 
        string $location, 
        DateTime $dateNeeded, 
        DateTime $dateRequested, 
        string $status
    ) 
    {
        $this->requestId = $requestId;
        $this->clientId = $clientId;
        $this->customName = $customName;
        $this->customDescription = $customDescription;
        $this->workerCount = $workerCount;
        $this->location = $location;
        $this->dateNeeded = $dateNeeded;
        $this->dateRequested = $dateRequested;
        $this->status = $status;
    }

    public function getRequestId(): int { return $this->requestId; }
    public function setRequestId(int $requestId): void { $this->requestId = $requestId; }

    public function getClientId(): int { return $this->clientId; }
    public function setClientId(int $clientId): void { $this->clientId = $clientId; }

    public function getCustomName(): ?string { return $this->customName; }
    public function setCustomName(?string $customName): void { $this->customName = $customName; }

    public function getCustomDescription(): ?string { return $this->customDescription; }
    public function setCustomDescription(?string $customDescription): void { $this->customDescription = $customDescription; }

    public function getWorkerCount(): int { return $this->workerCount; }
    public function setWorkerCount(int $workerCount): void { $this->workerCount = $workerCount; }

    public function getLocation(): string { return $this->location; }
    public function setLocation(string $location): void { $this->location = $location; }

    public function getDateNeeded(): DateTime { return $this->dateNeeded; }
    public function setDateNeeded(DateTime $dateNeeded): void { $this->dateNeeded = $dateNeeded; }

    public function getDateRequested(): DateTime { return $this->dateRequested; }
    public function setDateRequested(DateTime $dateRequested): void { $this->dateRequested = $dateRequested; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void { $this->status = $status; }
}

?>