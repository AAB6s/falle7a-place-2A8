<?php

class ServiceType 
{
    private int $typeId;
    private string $typeName;
    private string $icon;
    private string $shortDescription;

    public function __construct(int $typeId, string $typeName, string $icon, string $shortDescription = "") 
    {
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->icon = $icon;
        $this->shortDescription = $shortDescription;
    }

    public function getTypeId(): int { return $this->typeId; }
    public function setTypeId(int $typeId): void { $this->typeId = $typeId; }

    public function getTypeName(): string { return $this->typeName; }
    public function setTypeName(string $typeName): void { $this->typeName = $typeName; }

    public function getIcon(): string { return $this->icon; }
    public function setIcon(string $icon): void { $this->icon = $icon; }

    public function getShortDescription(): string { return $this->shortDescription; }
    public function setShortDescription(string $shortDescription): void { $this->shortDescription = $shortDescription; }
}

?>