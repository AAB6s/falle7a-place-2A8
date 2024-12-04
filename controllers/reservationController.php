<?php

require_once '../../../models/reservation.php';
require_once '../../../config/config.php'; 

class ReservationController
{
    private $db;

    // Constructor: Initialize the database connection
    public function __construct()
    {
        $this->db = config::getConnexion();
    }

    // Create a new reservation
    public function createReservation($debut_reservation, $fin_reservation, $description)
    {
        $reservation = new Reservation($debut_reservation, $fin_reservation, $description);
        $stmt = $this->db->prepare("INSERT INTO reservations (debut_reservation, fin_reservation, description) VALUES (?, ?, ?)");
        $stmt->execute([$reservation->getDebutReservation(), $reservation->getFinReservation(), $reservation->getDescription()]);
        return $reservation;
    }

    // Update an existing reservation
    public function updateReservation($id_reservation, $debut_reservation, $fin_reservation, $description)
    {
        $reservation = new Reservation($debut_reservation, $fin_reservation, $description, $id_reservation);
        $stmt = $this->db->prepare("UPDATE reservations SET debut_reservation = ?, fin_reservation = ?, description = ? WHERE id_reservation = ?");
        $stmt->execute([$reservation->getDebutReservation(), $reservation->getFinReservation(), $reservation->getDescription(), $reservation->getIdReservation()]);
        return $reservation;
    }

    // Delete a reservation
    public function deleteReservation($id_reservation)
    {
        $stmt = $this->db->prepare("DELETE FROM reservations WHERE id_reservation = ?");
        return $stmt->execute([$id_reservation]);
    }

    // Get all reservations
    public function getAllReservations()
    {
        $stmt = $this->db->query("SELECT * FROM reservations");
        $reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = new Reservation($row['debut_reservation'], $row['fin_reservation'], $row['description'], $row['id_reservation']);
        }
        return $reservations;
    }

    // Find a reservation by ID
    public function findReservation($id_reservation)
    {
        $stmt = $this->db->prepare("SELECT * FROM reservations WHERE id_reservation = ?");
        $stmt->execute([$id_reservation]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Reservation($row['debut_reservation'], $row['fin_reservation'], $row['description'], $row['id_reservation']);
        }
        return null; // Reservation not found
    }
}