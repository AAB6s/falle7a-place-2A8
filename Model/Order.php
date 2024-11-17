<?php
class Order
{
    private int $orderId;
    private int $clientId;
    private int $productId;
    private int $quantity;
    private string $orderDate;

    public function __construct(int $orderId, int $clientId, int $productId, int $quantity, string $orderDate)
    {
        $this->orderId = $orderId;
        $this->clientId = $clientId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->orderDate = $orderDate;
    }

    public function getOrderId(): int { return $this->orderId; }
    public function setOrderId(int $orderId): void { $this->orderId = $orderId; }

    public function getClientId(): int { return $this->clientId; }
    public function setClientId(int $clientId): void { $this->clientId = $clientId; }

    public function getProductId(): int { return $this->productId; }
    public function setProductId(int $productId): void { $this->productId = $productId; }

    public function getQuantity(): int { return $this->quantity; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }

    public function getOrderDate(): string { return $this->orderDate; }
    public function setOrderDate(string $orderDate): void { $this->orderDate = $orderDate; }
}
?>
