# Projects manager

A simple projects manager app written using [Laravel](https://laravel.com/) and [Filament](https://filamentphp.com/).

## Installation

Clone the repo locally:

```
git clone https://github.com/MichallB/projects-manager && cd projects-manager
```

Install PHP dependencies:

```
composer install
```

Setup configuration:

```
cp .env.example .env
```

Generate application key:

```
php artisan key:generate
```

Run database migrations:

```
php artisan migrate
```

Create Filament user:

```
php artisan make:filament-user
```

Run database seeder (if you want to generate sample data):

```
php artisan db:seed
```

Run the dev server:

```
composer run dev
```