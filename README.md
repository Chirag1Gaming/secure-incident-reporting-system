# 🔐 Secure Incident Reporting System

A highly secure and scalable Incident Reporting System built with **Laravel**, **MySQL**, **Bootstrap**, and **Spatie Permissions**, featuring real-time notifications, analytics dashboards, and role-based access control.

---

## 🚀 Features

### 🔒 Authentication & Roles (via Spatie)
- **Users**: Submit and view their own incidents.
- **Admins**: Manage all incidents with filters, analytics, and bulk actions.
- **Super Admins**: Manage users and permissions, delete incidents permanently.

### 📝 Incident Management
- Submit incidents with title, description, category, priority, date, and evidence upload.
- Filter and sort by date, category, or status.
- Status updates (Open, In Progress, Resolved).

### 📊 Dashboards
- **User Dashboard**: View & filter personal incidents.
- **Admin Dashboard**:
  - Total Incidents
  - Open vs Resolved (Pie chart)
  - Common Categories (Bar chart)
  - Avg. Resolution Time
- **Super Admin Dashboard**:
  - User management (add/edit/block roles)

### 📣 Real-Time Notifications
- Users receive in-app notifications when status of their incident is updated by an admin.

### 📁 Audit Logs
- Actions like creation, update, or delete are logged with user ID, action type, timestamp, and IP address.

---

## 🧪 Demo Accounts

| Role         | Email                 | Password  |
|--------------|-----------------------|-----------|
| Super Admin  | superadmin@example.com| password  |
| Admin        | admin@example.com     | password  |
| User         | user@example.com      | password  |

> 📌 You can create these accounts manually via Tinker or DB seed. Ensure roles are assigned using Spatie.

---

## 🛠️ Installation

```bash
git clone https://github.com/Chirag1Gaming/secure-incident-reporting-system.git
cd secure-incident-reporting-system

composer install
cp .env.example .env
php artisan key:generate

# Set up your database in .env

php artisan migrate
php artisan db:seed # if demo data added
php artisan serve
