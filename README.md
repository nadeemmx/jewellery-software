# JewelERP — Complete Jewellery & Bullion Management ERP

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13" />
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4" />
  <img src="https://img.shields.io/badge/TailwindCSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white" alt="Alpine.js" />
  <img src="https://img.shields.io/badge/Chart.js-4.x-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white" alt="Chart.js" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License" />
</p>

**JewelERP** is an enterprise-grade Jewellery Showroom & Chain Management System crafted specifically for the Indian jewellery retail ecosystem. It provides end-to-end management spanning live bullion rates, item-level BIS HUID tracking, specialized jewellery POS with dynamic wastage & making charges, old gold exchange valuation, karigar (artisan) job-work manufacturing, 11+1 gold savings schemes, multi-branch operations, and GST accounting.

---

## 🌟 Key Modules & Capabilities

### 1. Dashboard & Business Analytics
- Real-time today's sales, gross weight sold, and profit estimates.
- Current live stock valuation across Gold, Silver, Platinum, and Solitaires.
- Interactive Chart.js graphs for 24K gold rate trends and Sales vs. Purchase analytics.
- Branch-wise and staff-wise sales leaderboard.

### 2. Product Master & Item-Level Vault Tracking
- Multi-metal support: Gold (24K, 22K, 20K, 18K, 14K, 9K), Silver (999, 925), and Platinum (950).
- Unique piece tracking: Every piece has its own Gross Weight, Stone Weight, Net Weight, Diamond Carats, and individual Barcode / QR Tag.
- Consumable inventory (velvet boxes, rolls) with automated reorder alerts.

### 3. BIS Hallmarking & HUID Tracking
- 6-character HUID assignment linked to individual pieces.
- Assaying & Hallmarking center dispatch, receipt, and verification workflow.

### 4. Live Metal Rate Engine
- Daily branch-level or global rate updates for Gold, Silver, and Platinum.
- Automatic mathematical derivation of lower karats (22K, 20K, 18K, etc.) from 24K rate.
- Diamond pricing grid based on Shape, Cut, Color, and Clarity (4Cs).

### 5. Jewellery POS & Advanced Pricing Engine
- Supports per-gram, percentage, and fixed making charges.
- Configurable wastage percentage and stone/diamond charge deductions.
- GST compliance: Intra-state (1.5% CGST + 1.5% SGST) and Inter-state (3% IGST).
- Split settlements (Cash, Card, UPI, Bank Transfer, Old Gold deduction, Scheme maturity).
- Instant printing: **A4 Tax Invoice** and **80mm Thermal Receipt**.

### 6. Old Gold Exchange & Purchase
- Karat purity testing, stone deductions, and melting loss percentage configuration.
- Real-time valuation based on pure fine gold content.
- Customer KYC declarations and refinery batch transfer tracking.

### 7. Karigar Workshop, Custom Orders & Repairs
- **Job Work**: Metal issuance to artisans, loss/wastage tracking across production stages (casting, stone setting, polishing, QC).
- **Custom Orders**: Custom designs with locked gold rates and advance payment collection.
- **Repair Service**: Weighing upon receipt, assigned karigar, service fees, and customer delivery confirmations.

### 8. Gold Savings & Purchase Schemes
- 11+1 monthly installment plans with maturity bonus calculation.
- Automated installment schedule generation, receipt logging, and billing adjustments.

### 9. Multi-Branch & Security Governance
- Centralized head office visibility with branch-specific stock, counters, and metal rates.
- Inter-branch and counter-to-counter transfer logs.
- Multi-tier role permissions (`admin`, `manager`, `cashier`, `salesperson`, `artisan`).
- Approval workflows for manager overrides (rate changes, high discounts, invoice cancellations).
- Tamper-evident activity audit logs and login history tracking.

---

## 🛠️ Technology Stack

- **Backend**: Laravel 13, PHP 8.4
- **Database**: MySQL 8.x / MariaDB
- **Frontend**: Blade, Tailwind CSS v4, Alpine.js, Chart.js
- **Build Tool**: Vite 8

---

## 🚀 Quick Setup & Installation

### Prerequisites
- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ & npm
- XAMPP / MySQL Server

### 1. Clone the repository
```bash
git clone https://github.com/webotapp-academy/jewellery-software.git
cd jewellery-software
```

### 2. Install PHP and Node dependencies
```bash
composer install
npm install
npm run build
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Configure your database connection in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jewellry
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Seed Sample Data
```bash
php artisan migrate --seed
```

### 5. Launch the Application
```bash
php artisan serve
```
Open **[http://localhost:8000](http://localhost:8000)** in your browser.

---

## 👥 Demo Staff Credentials

All demo accounts use the default password: `password`

| Role | Email | Password | Primary Access |
| :--- | :--- | :--- | :--- |
| **Admin / Owner** | `admin@jewelerp.in` | `password` | Complete access to all 24 modules, audit logs & settings |
| **Branch Manager** | `manager@jewelerp.in` | `password` | POS, Inventory, Rates, Approvals, Staff & Reports |
| **Cashier** | `cashier@jewelerp.in` | `password` | POS, Checkout, Scheme Installments & Repair Receipts |
| **Salesperson** | `ananya@jewelerp.in` | `password` | POS, Customer CRM & Custom Order Bookings |
| **Artisan (Karigar)** | `rahim@jewelerp.in` | `password` | Workshop jobs, Manufacturing stages & Repair workbench |

---

## 🧪 Testing

Run the automated test suite covering authentication, pricing engine, GST math, and route security:

```bash
php artisan test
```

---

## 📄 License

This software is open-sourced under the [MIT license](LICENSE).
