<?php

    class TravelOffer 
    {

        private string $title;
        private string $destination;
        private DateTime $departure;
        private DateTime $return;
        private float $price;
        private bool $availability;
        private string $category;

        public function __construct(string $title, string $destination, DateTime $departure, DateTime $return, float $price, bool $availability, string $category) 
        {
            $this->title = $title;
            $this->destination = $destination;
            $this->departure = $departure;
            $this->return = $return;
            $this->price = $price;
            $this->availability = $availability;
            $this->category = $category;
        }

        public function getTitle(): string {return $this->title;}
        public function setTitle(string $title): void {$this->title = $title;}

        public function getDestination(): string {return $this->destination;}
        public function setDestination(string $destination): void {$this->destination = $destination;}

        public function getDeparture(): DateTime {return $this->departure;}
        public function setDeparture(DateTime $departure): void {$this->departure = $departure;}

        public function getReturn(): DateTime {return $this->return;}
        public function setReturn(DateTime $return): void {$this->return = $return;}

        public function getPrice(): float {return $this->price;}
        public function setPrice(float $price): void {$this->price = $price;}

        public function getAvailability(): bool {return $this->availability;}
        public function setAvailability(bool $availability): void {$this->availability = $availability;}

        public function getCategory(): string {return $this->category;}
        public function setCategory(string $category): void {$this->category = $category;}
    
    }
    
?>