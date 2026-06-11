<p align="center">
  <h1 align="center">🎓 Faculty Directory & Notice Board</h1>
  <p align="center">A full-stack university management system built with Core PHP (OOP) and MySQL</p>
  <p align="center">
    <img src="https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8+"/>
    <img src="https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
    <img src="https://img.shields.io/badge/CSS3-Custom_UI-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3"/>
    <img src="https://img.shields.io/badge/Architecture-OOP-orange?style=for-the-badge" alt="OOP"/>
    <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT"/>
  </p>
</p>

---

## 📌 Overview

**Faculty Directory** is a role-based university portal that enables administrators to manage faculty and student registrations and publish targeted institutional notices. Built entirely with **Core PHP (no frameworks)** using clean OOP architecture, it demonstrates real-world web development skills including secure authentication, prepared-statement database access, session management, and a custom-designed responsive UI.

> **Live Demo Note:** Import `database/schema.sql` to get a ready-to-run database with seeded users and sample notices.

---

## ✨ Features

### 🔐 Authentication & Access Control
- Dual-portal system — separate **Admin** and **User** login panels
- Session fixation prevention via `session_regenerate_id(true)` on every login
- Secure cookie settings: `HttpOnly`, `SameSite=Strict`, `use_strict_mode`
- Granular role-based routing: `Auth::requireAdmin()` / `Auth::requireUser()`

### 👥 User Management
- Self-registration with **Pending → Accepted / Rejected** approval workflow
- Admin can add, approve, reject, or delete users directly from the dashboard
- Profile update page: change name, email, or password at any time
- Passwords always stored as **bcrypt hashes** — never plain text

### 📢 Notice Board
- Publish notices to: **All Students**, **All Teachers**, or a **specific user by email**
- Full CRUD: create, edit, delete notices from the admin panel
- Users see only notices addressed to them or their group
- Each notice shows subject, full detail, publisher role, date, and audience

### 🏗️ Architecture & Code Quality
- **Singleton Database class** with a clean prepared-statement API (`select`, `selectOne`, `execute`)
- Five OOP classes: `Database`, `Auth`, `User`, `Notice`, `Admin`
- Single `bootstrap.php` autoloader — one include per page
- All output escaped with `htmlspecialchars()` — XSS-safe throughout
- Admin stats dashboard: live counts of total users, notices, and pending requests

---

## 🛠️ Tech Stack

| Layer          | Technology                        |
|----------------|-----------------------------------|
| Backend        | PHP 8+ — Core OOP (no framework)  |
| Database       | MySQL 5.7+ / MariaDB 10.4+        |
| Frontend       | HTML5 + CSS3 (custom, no Bootstrap) |
| Authentication | PHP Sessions + bcrypt (`PASSWORD_BCRYPT`) |
| Server         | Apache (XAMPP/WAMP) or PHP built-in |

---

## 📁 Project Structure

```
faculty-directory/
│
├── config/
│   └── config.php              # DB credentials & app constants
│
├── classes/
│   ├── Database.php            # Singleton DB — all queries via prepared statements
│   ├── Auth.php                # Session management, login/logout, access guards
│   ├── User.php                # User registration, login, CRUD, status updates
│   ├── Notice.php              # Notice board CRUD + per-user filtering
│   └── Admin.php               # Admin authentication (bcrypt + legacy upgrade)
│
├── includes/
│   ├── bootstrap.php           # Single include: loads config + all classes + session
│   ├── header.php              # Shared user panel navbar
│   └── footer.php              # Shared footer
│
├── user/                       # User-facing portal
│   ├── register.php            # Registration form (self-signup)
│   ├── dashboard.php           # Personalised notice feed
│   ├── notice.php              # Full notice detail view
│   ├── account.php             # Edit profile & change password
│   └── logout.php
│
├── admin/                      # Admin panel
│   ├── index.php               # Admin login
│   ├── dashboard.php           # Stats overview + recent notices
│   ├── notices.php             # Publish / edit / delete notices
│   ├── users.php               # Add / delete users
│   ├── requests.php            # Approve or reject pending registrations
│   ├── logout.php
│   └── includes/
│       └── header.php          # Admin navbar (separate from user panel)
│
├── assets/
│   └── css/style.css           # Full custom stylesheet — no external dependencies
│
├── database/
│   └── schema.sql              # Full DB schema + seeded demo data
│
├── index.php                   # User login page (app entry point)
├── .gitignore
└── README.md
```

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.4+
- Apache with `mod_rewrite` (XAMPP / WAMP / Laragon) **or** PHP's built-in server

---

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/faculty-directory.git
cd faculty-directory
```

### 2. Import the Database
```bash
mysql -u root -p < database/schema.sql
```
This creates the `faculty_directory` database and seeds it with demo admins, users, and notices.

### 3. Configure the Application
Open `config/config.php` and update your local settings:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // your MySQL username
define('DB_PASS', '');           // your MySQL password
define('DB_NAME', 'faculty_directory');

define('APP_URL',  'http://localhost/faculty-directory');  // match your server path
```

### 4. Start the Server

**Option A — XAMPP / WAMP:**
Place the project folder inside `htdocs/` (XAMPP) or `www/` (WAMP) and visit:
```
http://localhost/faculty-directory/
```

**Option B — PHP Built-in Server:**
```bash
php -S localhost:8000
```
Then open `http://localhost:8000`

---

## 🔑 Default Login Credentials

### Admin Panel → `/admin/index.php`

| Role           | Email                 | Password |
|----------------|-----------------------|----------|
| Administrator  | sarmad@gmail.com      | `admin`  |
| Super Admin    | fazal@gmail.com       | `admin`  |

### User Portal → `/index.php` (Demo Accounts)

| Type    | Email                          | Password |
|---------|--------------------------------|----------|
| Teacher | ahmed.raza@university.edu      | `user123`|
| Teacher | sara.malik@university.edu      | `user123`|
| Student | ali.hassan@student.edu         | `user123`|
| Student | fatima.zahra@student.edu       | `user123`|

> ⚠️ **Important:** Change all default passwords immediately when deploying to any public or production environment.

---

## 🔒 Security Implementation

| Threat            | Mitigation                                              |
|-------------------|---------------------------------------------------------|
| SQL Injection     | 100% prepared statements via `mysqli_stmt::bind_param` |
| XSS               | All output wrapped in `htmlspecialchars()`             |
| CSRF (sessions)   | `SameSite=Strict` cookies + session regeneration       |
| Session Fixation  | `session_regenerate_id(true)` on every login           |
| Password Storage  | `password_hash($pass, PASSWORD_BCRYPT)` — cost 12      |
| Info Disclosure   | DB errors logged server-side, never shown to users     |
| Unauthorized Access | Route-level guards: `Auth::requireAdmin()` / `requireUser()` |

---

## 📐 OOP Design Highlights

```
Database (Singleton)
└── Single shared connection across the full request lifecycle
└── Public API: select() · selectOne() · execute() · lastInsertId()
└── Private prepare() helper — binding never done outside this class

Auth (Static utility)
└── startSession() — idempotent, called from bootstrap.php
└── loginUser() / loginAdmin() — sets typed session keys
└── requireUser() / requireAdmin() — redirect guards on every protected page

User / Admin / Notice
└── Each class receives Database::getInstance() via constructor
└── No raw SQL outside these classes — all queries centralized
```

---

## 🗄️ Database Schema

```sql
admin          — id, username, email, password (bcrypt), role
registration   — u_id, u_name, u_email, u_password (bcrypt),
                 u_type (Student|Teacher), status (Pending|Accepted|Rejected)
notices        — ID, subject, detail, date, user (publisher name),
                 category (audience), role (publisher role)
```

---

## 🧪 Sample Data Included

The `schema.sql` ships with realistic seeded data:
- **2 admin accounts** (Administrator + Super Admin)
- **14 registered users** (4 teachers, 8 accepted students, 1 pending, 1 rejected)
- **10 sample notices** targeting various audiences (All Students, All Teachers, specific emails)

This lets you explore every feature of the system immediately after import — no manual data entry required.

---

## 🗺️ Possible Enhancements

- [ ] Password reset via email (PHPMailer / SMTP)
- [ ] File attachment support for notices (PDF circulars)
- [ ] Pagination for large notice/user lists
- [ ] Search & filter notices by category or date
- [ ] CSRF tokens on all forms
- [ ] REST API layer for mobile clients
- [ ] Dark mode toggle

---

## 👤 Author

**Sarmad Ali**  
[GitHub](https://github.com/your-username) · [LinkedIn](https://linkedin.com/in/your-profile)

---

## 📄 License

This project is licensed under the [MIT License](LICENSE) — free to use, modify, and distribute.

---

<p align="center">Built with ❤️ using Core PHP — no frameworks, no shortcuts.</p>
