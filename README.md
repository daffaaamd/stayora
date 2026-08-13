# 🌴 Stayora Resort — Luxury Hotel & Resort Management System

<p align="center">
  <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80" width="100%" alt="Stayora Resort Banner" style="border-radius: 12px;">
</p>

<p align="center">
  <strong>Stayora Resort</strong> is a full-featured, enterprise-grade Hotel & Resort Management System built with <strong>Laravel 11, PHP 8.3, MySQL, Blade, Tailwind CSS, Alpine.js, Chart.js, and DomPDF</strong>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/TailwindCSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-success?style=for-the-badge" alt="Status">
</p>

---

## 🌟 Key Features

### 👤 Guest Experience
- **Interactive Room Discovery & Availability Engine:** Real-time search by date range, guest count, and room category with accurate collision detection.
- **Seamless Booking Lifecycle:** Step-by-step reservation wizard with promo code discount validation and special requests.
- **Enterprise Payment Gateway Simulation:** Multi-channel payments (Bank Transfer VA, Credit Card, E-Wallet QRIS, Cash on Arrival).
- **Automated PDF Voucher Generator:** Download official branded booking confirmation vouchers rendered via DomPDF.
- **Guest Self-Service Portal:** Interactive dashboard to manage bookings, track check-in status, order room services, and submit verified reviews.
- **High-Resolution Visual Gallery:** Categorized 42-photo resort showcase with lightbox modals.

### 🏢 Operations & Management (RBAC)
- **Role-Based Access Control:** 4 tailored administrative roles (`Admin`, `Front Desk`, `Housekeeping`, `Finance`).
- **Interactive Management Dashboard:** Real-time KPI cards (Occupancy rate, available rooms, today's arrivals/departures, monthly revenue, and trends powered by Chart.js).
- **Front Desk Operations:** Fast guest check-in & check-out workflows, folio management, and key card assignment.
- **Housekeeping & Room Status:** Live room condition tracker (`available`, `occupied`, `cleaning`, `maintenance`).
- **Service Orders & Room Add-ons:** Manage in-room dining, spa reservations, and transport services.
- **Financial Analytics & Transactions:** Revenue reporting by period and room categories, transaction ledgers, and promo code management.
- **Complete Audit Trail:** Automatic logging of user activities, booking state transitions, and payment events.

---

## 👥 Demo Accounts

All demo accounts share the password: `password`

| Role | Email | Password | Primary Functions |
| :--- | :--- | :--- | :--- |
| **General Manager (Admin)** | `admin@stayora.test` | `password` | Complete access, analytics, audit logs, room inventory & pricing |
| **Front Desk Manager** | `frontdesk@stayora.test` | `password` | Check-in, check-out, booking operations, key cards |
| **Executive Housekeeper** | `housekeeping@stayora.test` | `password` | Room status, cleaning inspection, maintenance |
| **Financial Controller** | `finance@stayora.test` | `password` | Payments, transactions, revenue analytics |
| **VIP Guest (Customer)** | `guest@stayora.test` | `password` | Room reservations, payments, vouchers, reviews |

---

## 🚀 Installation & Setup Guide

### 1. Clone the Repository
```bash
git clone https://github.com/daffaaamd/stayora.git
cd stayora
```

### 2. Install PHP & Node Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
Copy the environment template and set your database credentials:
```bash
cp .env.example .env
php artisan key:generate
```

Edit your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stayora
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### 5. Build Assets & Start Application
```bash
npm run build
php artisan serve
```

Access the application at `http://127.0.0.1:8000` (or `http://stayora.test` if using Laragon / Valet).

---

## 🧪 Automated Testing

Execute the comprehensive test suite (29 tests, 78 assertions):
```bash
php artisan test
```

---

## 👨‍💻 Author & Credits

**Designed & Developed by Daffa Ahmad Baihaqi**  
*Stayora Hospitality Technologies*

---

## 📄 License
This project is open-source software licensed under the [MIT license](LICENSE).
