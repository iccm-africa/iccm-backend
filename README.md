ICCM Backend
============

Purpose
-------

This tool should help with the registration for the ICCM conferences.

Architecture
------------

This software is written in Laravel.
The long-term goal is to have a client written separately, that communicates with this backend.

### API
A basic API is already implemented providing the following endpoints:
- `/api/users`
- `/api/groups`
- `/api/postregistrations`

The API is protected by a token, which is generated on login after the user has been authenticated using `/api/login`

A new user can be registered by sending a POST request to `/api/users/register`.

Setup of Development Environment
--------------------------------

### Requirements
- PHP 8.1 or higher
- MySQL 5.7 / MariaDB 10.3 or higher
- Composer 2.0 or higher

### Setup

To setup a local development environment with sample data, run these commands:

```
git clone https://github.com/iccm-africa/iccm-backend.git
cd iccm-backend
composer install --no-dev
cp .env.example .env
# TODO: edit .env and set your database credentials etc.
# set unique application key
php artisan key:generate
# initialise the database
php artisan migrate
# load sample data
mysql -u <username> <dbname> -p < database/database-example.sql
mysql -u <username> <dbname> -p < database/payment-methods.sql
# update the admin user with email address and valid password
php artisan tinker --execute="\$user = User::where('name', 'admin')->first();\$user->password = Hash::make('NOT_TopSecret1234');\$user->email = 'admin@example.org';\$user->save();"
php artisan serve
```

### Setup with Docker and DDEV
Prerequisites: Docker and ddev installed
(see: https://ddev.readthedocs.io/en/latest/users/install/ddev-installation/).
```
ddev start
ddev composer install --no-dev
cp .env.example .env
# TODO: edit .env and set your database to use ddev default config.
ddev artisan key:generate
ddev artisan migrate
ddev mysql < database/database-example.sql
ddev mysql < database/payment-methods.sql
ddev artisan tinker --execute="\$user = User::where('name', 'admin')->first();\$user->password = Hash::make('NOT_TopSecret1234');\$user->email = 'admin@example.org';\$user->save();"
```

Upgrade Laravel version
-----------------------

Follow the instructions at eg. https://laravel.com/docs/9.x/upgrade

Update the composer dependencies in composer.json, according to the upgrade instructions.

Then run:

```
composer update
composer install
```

Hints for Developers
--------------------

* The models are defined in `app`, eg. `app/Group.php`
* The views are defined in `resources/views/`, eg. `about.blade.php` and `auth/register.blade.php`
* You find the controllers in `app/Http/Controllers/`, eg. `GroupController.php` and `AdminController.php`

License
-------

This software is licensed under the GNU AGPLv3.
