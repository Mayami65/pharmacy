<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# Pharmacy Management System

A comprehensive web application for managing pharmacy operations, built with Laravel (PHP) and JavaScript. This system streamlines inventory, sales, prescriptions, and customer management for pharmacies of any size.

## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Project Overview

This Pharmacy Management System is designed to automate and simplify the daily tasks of a pharmacy. It provides tools for tracking medicine inventory, processing sales and prescriptions, managing customers and suppliers, and generating reports. The application is built using the Laravel framework for the backend and modern JavaScript for the frontend, ensuring a robust and user-friendly experience.

## Features

- **Inventory Management:** Track medicines, batches, expiry dates, and stock levels.
- **Sales & Billing:** Process sales, generate invoices, and manage payment records.
- **Prescription Handling:** Store and manage customer prescriptions securely.
- **Customer & Supplier Management:** Maintain detailed records for customers and suppliers.
- **User Authentication & Roles:** Secure login system with role-based access control.
- **Reporting & Analytics:** Generate sales, inventory, and financial reports.
- **Responsive UI:** Accessible from desktops, tablets, and mobile devices.

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** JavaScript, HTML, CSS
- **Package Managers:** Composer (PHP), npm (JavaScript)
- **Database:** MySQL (or compatible)
- **Version Control:** Git

## Getting Started

Follow these steps to set up the project for local development.

### Prerequisites

- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL (or compatible database)
- Git

### Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/Mayami65/pharmacy.git
   cd pharmacy
   ```

2. **Install PHP dependencies:**
   ```sh
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```sh
   npm install
   ```

4. **Set up environment variables:**
   - Copy `.env.example` to `.env` and update with your database and mail configuration.

5. **Set up the database:**
   - Create a new database.
   - Update `.env` with your database credentials.
   - Run migrations:
     ```sh
     php artisan migrate
     ```

6. **Build frontend assets:**
   ```sh
   npm run build
   ```

## Configuration

- All environment-specific settings are in the `.env` file.
- Update database, mail, and other service credentials as needed.

## Usage

- Start the development server:
  ```sh
  php artisan serve
  ```
- Access the application at `http://localhost:8000`.

## Testing

- Run PHP tests:
  ```sh
  ./vendor/bin/phpunit
  ```
- Run JavaScript tests:
  ```sh
  npm test
  ```

## Contributing

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/YourFeature`).
3. Commit your changes (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Create a new Pull Request.

## Seeded Login Details

The following user accounts are automatically created when you run the database seeders:

| Role        | Email                      | Password  |
|-------------|----------------------------|-----------|
| Manager     | manager@pharmacy.com       | password  |
| Pharmacist  | pharmacist@pharmacy.com    | password  |

> **Note:**
> - All default users have the password `password`.
> - You can change these credentials after logging in for the first time.
> - If you reseed the database, these accounts will be recreated if they do not already exist.

## License

This project is licensed under the MIT License.

## Contact

For questions or support, open an issue or contact [Mayami65](https://github.com/Mayami65).
