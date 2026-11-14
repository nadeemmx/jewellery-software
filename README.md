# JewelERP — Jewellery Management System

[![Laravel 13.x](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.4](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS v4](https://img.shields.io/badge/TailwindCSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js 3.x](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)](https://alpinejs.com)
[![Chart.js 4.x](https://img.shields.io/badge/Chart.js-4.x-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white)](https://chartjs.org)
[![License: MIT](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](https://opensource.org/licenses/MIT)

## Project Overview

**JewelERP** is an enterprise-grade Jewellery Showroom & Chain Management System crafted specifically for the Indian jewellery retail ecosystem. It provides end-to-end management spanning live bullion rates, item-level BIS HUID tracking, specialised jewellery POS with dynamic wastage & making charges, old gold exchange valuation, karigar (artisan) job-work manufacturing, 11+1 gold savings schemes, multi-branch operations, and GST accounting.

This is the **Public Portfolio Edition** — a carefully curated selection of core engineering features demonstrating modern full-stack Laravel development capabilities.

## Problem Statement

Indian jewellery retailers face challenges managing:
- Live bullion rate volatility across multiple branches
- BIS Hallmarking compliance and HUID tracking
- Dynamic wastage and making charge calculations
- Old gold exchange valuation with purity testing
- 11+1 gold savings scheme installment tracking
- Multi-branch inventory and staff governance
- GST-compliant invoice generation and reporting

JewelERP solves these problems with a complete, modern ERP system built on Laravel 13 with a service-oriented architecture.

## Key Features (Public Edition)

| Feature | Description |
|---|---|
| **Authentication** | Secure login with email/password, rate limiting (5 attempts/60s), active user validation, logout |
| **Dashboard** | Real-time business analytics with Chart.js graphs, branch-wise performance, sales and stock valuation |
| **Live Metal Rates** | Indian domestic rate fetching with international spot fallback, persistence to database, 11 major hubs |
| **Jewellery POS** | Per-gram/fixed/percentage making charges, wastage %, stone/diamond charges, GST (CGST/SGST/IGST) breakdown, invoice generation |
| **Customer CRM** | Basic customer search and filtering, birthday/anniversary tracking |
| **Product Inventory** | Multi-metal support (Gold 24K/22K/20K/18K/14K/9K, Silver 999/925, Platinum 950), HUID tracking |
| **Multi-Branch RBAC** | Role-based access control (admin/manager/cashier), branch-specific stock and rates visibility |
| **Database Migrations** | 5 essential migrations: users, cache, jobs, branches_counters_rbac, metal_rates_products |
| **Price Calculator** | Complete jewellery price breakdown with metal value, wastage, stone charges, and 3% GST computation |
| **Environment Configuration** | `.env.example` with all required variables for setup |

## Public Edition vs Private Edition

| Feature | Public Edition | Private Edition |
|---|---|---|
| Authentication system | ✅ Included | ✅ Included |
| Dashboard with analytics | ✅ Included | ✅ Included |
| Live metal rate engine | ✅ Included (with fallback) | ✅ Included |
| Jewellery POS with GST | ✅ Included | ✅ Included |
| Customer CRM | ✅ Included (basic) | ✅ Included (full) |
| Product inventory with HUID | ✅ Included | ✅ Included |
| 11+1 Gold savings schemes | ❌ Excluded | ✅ Included |
| Old gold exchange & refinery | ❌ Excluded | ✅ Included |
| Karigar workshop & custom orders | ❌ Excluded | ✅ Included |
| Repair jobs management | ❌ Excluded | ✅ Included |
| Hallmark records & diamond stones | ❌ Excluded | ✅ Included |
| Manufacturing orders | ❌ Excluded | ✅ Included |
| Full supplier & purchase management | ❌ Excluded | ✅ Included |
| Financial vouchers & expenses | ❌ Excluded | ✅ Included |
| Staff attendance & salary payments | ❌ Excluded | ✅ Included |
| 50+ additional tables | ❌ Excluded | ✅ Included |
| Live external API integration | ⚠️ Fallback only | ✅ Full integration |

**Important:** The private edition contains the complete original project with all 24+ modules. The public edition is a functionally complete portfolio demonstrating core engineering capabilities while keeping proprietary business logic private.

## Technology Stack

| Category | Details |
|---|---|
| **Backend Framework** | Laravel 13 (PHP 8.4) |
| **Database** | MySQL 8.x / MariaDB (testing: SQLite in-memory) |
| **ORM** | Eloquent ORM |
| **Frontend** | Blade templates, Tailwind CSS v4, Alpine.js 3.x, Chart.js 4.x |
| **Build Tool** | Vite 8 |
| **Authentication** | Laravel session-based auth with rate limiting |
| **Testing** | PHPUnit 12 with SQLite in-memory database |
| **API** | Laravel routes with authentication middleware |

## System Architecture

JewelERP follows a modular Laravel architecture:

```
app/
  Http/Controllers/      — Request handling and routing
  Http/Middleware/       — EnsureUserIsActive middleware
  Models/                — 7 essential Eloquent models (User, etc.)
  Services/              — JewelleryPriceCalculator, AuditService
  Providers/             — AppServiceProvider
database/
  migrations/            — 5 essential migration files
  seeders/               — Database seeding configs
resources/
  views/                 — Blade templates (auth, dashboard, layouts)
  css/                   — Tailwind directives
  js/                    — Alpine.js, router, config
routes/
  web.php                — 30+ web routes organized by module
```

## Prerequisites

- PHP 8.4 or higher
- Composer 2.x
- Node.js 20.x (with npm)
- MySQL 8.x or MariaDB 10.x (or SQLite for testing)
- Git

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/nadeemmx/jewellery-software.git
cd jewellery-software
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
npm run build
```

### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database and mail server settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jewellry
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations

```bash
php artisan migrate --force
```

### 6. Set Up Storage Links

```bash
php artisan storage:link
```

### 7. Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## Configuration

### Environment Variables (`.env`)

| Variable | Description | Default |
|---|---|---|
| `APP_NAME` | Application name | `JewelERP` |
| `APP_ENV` | Environment | `local` |
| `APP_DEBUG` | Debug mode | `true` |
| `DB_CONNECTION` | Database driver | `mysql` |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | `jewellry` |
| `DB_USERNAME` | Database user | `root` |
| `DB_PASSWORD` | Database password | *(empty)* |
| `BCRYPT_ROUNDS` | Password bcrypt rounds | `12` |
| `LOG_LEVEL` | Log level | `debug` |
| `CACHE_STORE` | Cache driver | `database` |
| `QUEUE_CONNECTION` | Queue connection | `database` |
| `MAIL_MAILER` | Mail sender | `log` |

### Database Setup

The application uses 5 essential database tables:

1. **users** — User accounts with branch, role, employee_code, commission, salary, mfa, is_active
2. **cache** — Laravel cache table
3. **jobs** — Laravel jobs table
4. **branches** — Branch offices with code, phone, email, address, GST
5. **counters** — Counters per branch for POS transactions
6. **metal_rates** — Live gold/silver/platinum rates per gram per branch
7. **diamond_rate_configs** — Diamond pricing grid by shape and quality
8. **settings** — Key-value configuration store

## Running the Application

### Login Credentials

The public edition includes the following demo accounts (all passwords: `password`):

| Role | Email | Permissions |
|---|---|---|
| **Admin** | `admin@jeweller.com` | Full access to all modules |
| **Manager** | `manager@jeweller.com` | Branch management, CRUD on products/invoices |
| **Cashier** | `cashier@jeweller.com` | POS operations, invoice generation |
| **Salesperson** | `sales@jeweller.com` | Sales, customer management |
| **Artisan** | `artisan@jeweller.com` | View-only, workshop tasks |

### Core Workflows

#### Live Metal Rates

1. Navigate to `/rates` dashboard
2. Click "Sync Rates" to fetch latest Indian domestic rates
3. System automatically derives 22K/18K/14K/9K from 24K base rate
4. Rates are persisted to database for branch-specific pricing

#### Jewellery POS

1. Select customer or create new
2. Add items with metal type, weight, purity, stone weight
3. Choose making charge type (fixed/percentage) and rate
4. Add stone/diamond charges if applicable
5. System calculates: metal value + wastage + stone charges + 3% GST
6. Generate tax invoice or thermal receipt

#### Price Calculator

Use the `JewelleryPriceCalculator` service:

```php
$calc = new JewelleryPriceCalculator();
$res = $calc->calculateInvoice([
    [
        'gross_weight' => 10,
        'stone_weight' => 0,
        'metal_rate' => 10000,
        'making_charge_type' => 'fixed',
        'making_charge_rate' => 10000,
        'stone_charge' => 5000,
        'gst_rate' => 3,
    ]
]);
// Result: subtotal=115000, cgst=1725, sgst=1725, grand_total=118450
```

## API Documentation

**Authentication:** All API endpoints require Laravel session-based authentication.

**Key Endpoints:**

| Method | Endpoint | Description |
|---|---|---|
| `GET /login` | Show login form |
| `POST /login` | Authenticate user |
| `POST /logout` | Logout |
| `GET /` | Dashboard (requires auth) |
| `GET /rates` | View metal rates (requires auth) |
| `POST /rates/sync` | Sync live metal rates (requires auth) |
| `GET /pos` | POS interface (requires auth) |
| `POST /pos/calculate` | Calculate POS price (requires auth) |
| `GET /customers` | Customer list (requires auth) |
| `POST /pos/checkout` | Checkout and create invoice (requires auth) |

## Testing

### Run Test Suite

```bash
vendor/bin/phpunit --no-coverage
```

### Test Results

All 18 tests pass with 128 assertions:

- **Feature Tests (15):** Price calculation with GST rules, old gold valuation, module access, POS operations, login validation, rates sync, CRUD across core modules, CRM campaigns, delete operations
- **Unit Tests (1):** Basic test infrastructure

### Test Coverage

- JewelleryPriceCalculator — invoice total calculation with GST, old gold valuation
- Authentication — login requires valid password + active account, guests redirected to login
- Module access — all protected routes require auth
- CRUD operations — delete across core modules
- Live metal rates sync — domestic rates and international fallback

## Security Considerations

- Passwords hashed with bcrypt (12 rounds)
- Rate limiting on login (5 attempts per throttle key)
- Active user check middleware blocks deactivated accounts
- SQL injection prevention via Eloquent parameterized queries
- XSS prevention via Blade escaping (`{{ }}` vs `{!! !!}`)
- CSRF protection on all forms
- Environment variables never committed (`.env` in `.gitignore`)
- Rate limiter based on transliterated email + IP address

## Development Status

- **Current Version:** 1.0.0 (Public Portfolio Edition)
- **Framework:** Laravel 13
- **PHP Version:** 8.4
- **Test Status:** ✅ All 18 tests passing (128 assertions)
- **Build Status:** ✅ Vite build successful
- **Last Updated:** 2026

## Future Roadmap

Features planned for the private edition only:

- 11+1 gold savings schemes with maturity bonus tracking
- Old gold exchange with refinery valuation and KYC declarations
- Karigar workshop management with job-tracking and custom orders
- Repair job management with service history
- Hallmark record keeping and BIS HUID assignment
- Diamond stone inventory with 4Cs grading
- Manufacturing order processing and production tracking
- Full supplier and purchase management
- Financial voucher and expense tracking
- Staff attendance, salary, and commission management
- Advanced reporting and analytics dashboards
- Multi-tenant branch governance with 5-role RBAC

## License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

**Copyright © 2026 Nadeem Qureshi** — All rights reserved.

## Maintainer Information

**Project Owner / Maintainer:** Nadeem Qureshi  
**GitHub:** [@nadeemmx](https://github.com/nadeemmx)  
**Email:** imnadeemx@gmail.com  

For technical inquiries, recruitment, or business partnership opportunities, please contact via GitHub.

---

*This is the Public Portfolio Edition — a carefully selected subset of the complete JewelERP system demonstrating engineering capabilities for recruiter evaluation. The complete private edition is available at https://github.com/nadeemmx/jewellery-software-Full*