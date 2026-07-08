<?php

class Reservation
{
    private $id_reservation;
    private $debut_reservation;
    private $fin_reservation;
    private $description;
    private $id_employe;

    // Constructor
    public function __construct($debut_reservation, $fin_reservation, $description, $id_employe, $id_reservation = null)
    {
        $this->id_reservation = $id_reservation;
        $this->debut_reservation = $debut_reservation;
        $this->fin_reservation = $fin_reservation;
        $this->description = $description;
        $this->id_employe = $id_employe;
    }

    // Getters
    public function getIdReservation()
    {
        return $this->id_reservation;
    }

    public function getDebutReservation()
    {
        return $this->debut_reservation;
    }

    public function getFinReservation()
    {
        return $this->fin_reservation;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getIdEmploye()
    {
        return $this->id_employe;
    }

    // Setters
    public function setDebutReservation($debut_reservation)
    {
        $this->debut_reservation = $debut_reservation;
    }

    public function setFinReservation($fin_reservation)
    {
        $this->fin_reservation = $fin_reservation;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setIdEmploye($id_employe)
    {
        $this->id_employe = $id_employe;
    }
}