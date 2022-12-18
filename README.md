# Expense Manager
Expense Manager is a simple API pack to manage your expenses. It is built using Laravel.

## Table of Contents
1. [Requirements](#requirements)
2. [Features](#features)
3. [Installation](#installation)
4. [Usage](#usage)
5. [API Endpoints](#api-endpoints)
6. [Note](#note)
7. [License](#license)

## Requirements
1. PHP >= 7.3
2. Composer
3. Laravel >= 8.0
4. MySQL

## Features
1. Register a user
2. Login a user
3. Get the authenticated user
4. Get all expenses
5. Create an expense
6. Get a single expense
7. Get all outstanding expenses

## Installation
1. Clone the repository
2. Run `composer install`
3. Run `php artisan migrate`
4. Run `php artisan serve`

## Usage
1. Register a user
2. Login to get the access token
3. Use the access token to access the API endpoints

## API Endpoints
1. `POST /api/signup` - Register a user
2. `POST /api/login` - Login a user
3. `GET /api/user` - Get the authenticated user
4. `GET /api/expense/all` - Get all expenses
5. `POST /api/expense` - Create an expense
6. `GET /api/expense/{id}` - Get a single expense
7. `GET /api/expense/outstanding` - To get all outstanding expenses

## Note
The API endpoints are protected by the `auth:sanctum` (the default laravel auth) middleware. You need to pass the Bearer access token in the `Authorization` header to access the endpoints.
The paid_at added for future use. It is not used in the current version.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
