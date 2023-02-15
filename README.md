ICCM Backend
============

Purpose
-------

This tool should help with the registration for the ICCM conferences.

Architecture
------------

This software is written in Laravel.
The long-term goal is to have a client written separately, that communicates with this backend.

Setup of Development Environment
--------------------------------

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
# update the admin user with email address and valid password
php artisan tinker --execute="\$user = User::where('name', 'admin')->first();\$user->password = Hash::make('NOT_TopSecret1234!');\$user->email = 'admin@example.org';\$user->save();"
```

