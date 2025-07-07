News Portal 
This guide will walk you through the steps to get the News Portal application up and running on your local machine.

Prerequisites
Before you begin, ensure you have the following installed on your system:

PHP (version 8.2 or higher)

Composer

Node.js & npm

A database server (like MySQL, PostgreSQL, or SQLite)

Installation and Setup
Clone the repository:

Bash

git clone https://github.com/bllall/news-port-laravel.git
cd news-port-laravel
Install dependencies:

Install the PHP and JavaScript dependencies using Composer and npm:

Bash

composer install
npm install
Set up your environment:

Create a .env file by copying the example file:

Bash

cp .env.example .env
Then, generate an application key:

Bash

php artisan key:generate
Configure your database:

Open the .env file and update the database connection details (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).


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


# I use gmail server to send mails :
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


Run database migrations and seed the database:

This will create the necessary tables and populate them with initial data, including the admin user.

Bash

php artisan migrate --seed
Running the Application
To run the application, you can use the dev script defined in the composer.json file:

Bash

composer run dev
This command will concurrently start the following services:

The Laravel development server

The queue listener

The pail logger

The Vite server for frontend assets

ueue & Job Monitoring
Use Laravel Horizon for comprehensive job monitoring:

Redis & Horizon Setup:
bash# Install Redis
sudo apt install redis-server

# Configure Redis to start on boot
sudo systemctl enable redis-server
sudo systemctl start redis-server

# Install Horizon
composer require laravel/horizon
php artisan horizon:install


Important Queue Commands:
# Start Horizon 
php artisan horizon

# Access Horizon dashboard
http://yoursite.com/horizon

Horizon Features:

Real-time Monitoring: Watch newsletter jobs as they process
Failed Job Management: Retry failed newsletter sends
Performance Metrics: Track job processing times and throughput
Queue Balancing: Distribute newsletter load across workers




Logging In
Admin User:

Email: admin@example.com

Password: password

Regular User:

Email: test@example.com

Password: password