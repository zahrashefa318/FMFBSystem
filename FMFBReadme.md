# FMFB Loan Management System

**A comprehensive Laravel application implementing FMFB (First MicroFinance Bank) loan logic and workflow.**

---

## 📘 Table of Contents

1. [Overview](#overview)  
2. [Features](#features)  
3. [Tech Stack](#tech-stack)  
4. [Prerequisites](#prerequisites)  
5. [Setup & Installation](#setup--installation)  
6. [Development Setup](#development-setup)  
7. [Usage](#usage)  
8. [Testing](#testing)  
9. [Configuration](#configuration)  
10. [Contributing](#contributing)  
11. [License](#license)  
12. [Contact](#contact)

---

## Overview

This repository implements a complete loan management system for FMFB, including:

- `FMFBLogics` module with business logic and repayment calculations  
- Laravel application for UI, user roles, loan workflows, and printable documentation

---

## Features

- Role-based authentication (Receptionist & Loan Officer)  
- Customer and loan entry with validation  
- Repayment schedule creation and processing  
- Filterable dashboards (zip code, loan status)  
- Printable loan statements

---

## Tech Stack

- **Backend:** PHP ≥ 8.0, Laravel (MVC, Services, Policies), MySQL  
- **Frontend:** HTML, CSS, JavaScript with print-friendly styling  
- **Testing:** PHPUnit or Pest

---

## Prerequisites

Before you start, ensure these are installed:

- PHP ≥ 8.0  
- Composer  
- MySQL  
- Node.js & NPM (for front-end assets)

---

## Setup & Installation

Clone and configure the project:

```bash
git clone https://github.com/zahrashefa318/FMFBLogics.git fmfb-loan-system
cd fmfb-loan-system
cp .env.example .env
composer install
npm install
npm run dev
php artisan key:generate
php artisan migrate --seed
php artisan serve
