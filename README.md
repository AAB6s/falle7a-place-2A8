# Falle7a Place

<p align="center">
  <img src="smart/view/assets/images/logo.svg" alt="Falle7a Place" width="240">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Backend-PHP-777BB4?style=flat-square" alt="PHP">
  <img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=flat-square" alt="MySQL">
  <img src="https://img.shields.io/badge/Frontend-HTML%20%7C%20CSS%20%7C%20JavaScript-F7DF1E?style=flat-square" alt="HTML CSS JavaScript">
  <img src="https://img.shields.io/badge/Payments-Stripe-635BFF?style=flat-square" alt="Stripe">
  <img src="https://img.shields.io/badge/Email-PHPMailer-D14836?style=flat-square" alt="PHPMailer">
</p>

<p align="center">
  <b>Marketplace and service-management web platform</b>
</p>

---

## Overview

**Falle7a Place** is a PHP and MySQL web application for managing an online agricultural marketplace and its service operations.

The platform has two main spaces:

- **Front office** for customers: browsing products, managing a cart, placing orders, paying online, requesting services, making reservations, and sending complaints.
- **Back office** for administrators: managing users, employees, products, categories, services, orders, reservations, complaints, and dashboard statistics.

---

## Main Features

- Account registration, login, email verification, password reset, and role-based access
- Product catalog with categories, images, prices, stock, ratings, search, and sorting
- Cart, order tracking, transaction history, and online payment through Stripe
- Service catalog with service types, service requests, approval workflow, and planning
- Employee management with availability, reservation assignment, and profile data
- Complaint and feedback management from customer submission to admin follow-up
- Back-office dashboards with charts and operational statistics
- Email notifications powered by PHPMailer

---

## Tech Stack

| Layer | Tools |
| --- | --- |
| Backend | PHP, PDO, Composer |
| Database | MySQL or MariaDB |
| Frontend | HTML, CSS, JavaScript, Bootstrap templates |
| Authentication | PHP sessions, JWT, email verification |
| Payments | Stripe PHP SDK |
| Email | PHPMailer with SMTP |

---

## Project Structure

```text
.
|-- falle7a.sql
|-- .env.example
`-- smart
    |-- config.php
    |-- controller
    |-- model
    |-- view
    |-- composer.json
    `-- composer.lock
```

| Path | Role |
| --- | --- |
| `falle7a.sql` | Database schema |
| `.env.example` | Local configuration template |
| `smart/config.php` | Database, email, and payment configuration |
| `smart/controller` | Application logic and database operations |
| `smart/model` | Data models |
| `smart/view` | Front-office and back-office pages |
| `smart/composer.json` | PHP package list |

---

## Requirements

- PHP 8.x
- MySQL or MariaDB
- Composer
- Apache, XAMPP, WAMP, Laragon, or another PHP-compatible local server

---

## Setup

1. Clone the repository.

```bash
git clone https://github.com/AAB6s/projetWeb2A.git
cd projetWeb2A
```

2. Create the local configuration file.

```bash
cp .env.example .env
```

3. Fill the database, Stripe, and SMTP values in `.env`.

4. Install PHP dependencies.

```bash
cd smart
composer install
```

5. Import the database schema from `falle7a.sql`.

6. Place the project inside your web server directory and open:

```text
http://localhost/smart/view/
```

---

## Configuration

| Variable | Purpose |
| --- | --- |
| `DB_HOST` | Database host |
| `DB_NAME` | Database name |
| `DB_USER` | Database username |
| `DB_PASSWORD` | Database password |
| `STRIPE_SECRET_KEY` | Stripe server key |
| `STRIPE_PUBLISHABLE_KEY` | Stripe browser key |
| `SMTP_HOST` | SMTP server |
| `SMTP_USERNAME` | SMTP account |
| `SMTP_PASSWORD` | SMTP password |
| `SMTP_FROM_EMAIL` | Sender email |
| `SMTP_FROM_NAME` | Sender name |
| `ORDER_NOTIFICATION_EMAIL` | Order notification receiver |
| `JWT_SECRET` | Token signing secret |
| `JWT_ALGORITHM` | Token signing algorithm |

---

<p align="center">
  <sub>Falle7a Place - PHP marketplace and service-management platform</sub>
</p>
