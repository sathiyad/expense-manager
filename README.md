# Expense Manager
Expense Manager is a simple API pack to manage your expenses. It is built using Laravel.

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
6. `GET /api/expenses/{id}` - Get a single expense
7. `GET /api/expenses/outstanding` - To get all outstanding expenses

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
