# News Portal

This guide will walk you through the steps to set up the News Portal application on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

* PHP (version 8.2 or higher)
* Composer
* Node.js & npm
* A database server (like MySQL, PostgreSQL, or SQLite)

## Installation and Setup

### 1. Clone the repository

```bash
git clone https://github.com/bllall/news-port-laravel.git
cd news-port-laravel
```

### 2. Install dependencies

Install the PHP and JavaScript dependencies using Composer and npm:

```bash
composer install
npm install
```

### 3. Set up your environment

Create a `.env` file by copying the example file:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

### 4. Configure your database

Open the `.env` file and update the database connection details as follows:

```env
# Application
APP_NAME="Your News Site"
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_website
DB_USERNAME=root
DB_PASSWORD=

# Redis Configuration (for queues and caching)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Queue Configuration
QUEUE_CONNECTION=redis
QUEUE_DEFAULT=default
QUEUE_FAILED_DRIVER=database

# Mail Configuration (using Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=bamer8353@gmail.com
MAIL_PASSWORD=my-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=bamer8353@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# File Storage
FILESYSTEM_DISK=local
```

### 5. Run database migrations and seed the database

This command will create the necessary tables and populate them with initial data, including the admin user.

```bash
php artisan migrate --seed
```

## Running the Application

To run the application, use the `dev` script defined in the `composer.json` file:

```bash
composer run dev
```

This command will start the following services concurrently:

* The Laravel development server
* The queue listener
* The pail logger
* The Vite server for frontend assets

## Queue & Job Monitoring

Use Laravel Horizon for comprehensive job monitoring:

### Redis & Horizon Setup

1. Install Redis:

```bash
sudo apt install redis-server
```

2. Configure Redis to start on boot:

```bash
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

3. Install Horizon:

```bash
composer require laravel/horizon
php artisan horizon:install
```

### Important Queue Commands

* Start Horizon:

```bash
php artisan horizon
```

* Access Horizon dashboard: [http://yoursite.com/horizon](http://yoursite.com/horizon)

### Horizon Features:

* **Real-time Monitoring**: Watch newsletter jobs as they process.
* **Failed Job Management**: Retry failed newsletter sends.
* **Performance Metrics**: Track job processing times and throughput.
* **Queue Balancing**: Distribute newsletter load across workers.

## Logging In

* **Admin User**:

  * Email: [admin@example.com](mailto:admin@example.com)
  * Password: password

* **Regular User**:

  * Email: [test@example.com](mailto:test@example.com)
  * Password: password

---
