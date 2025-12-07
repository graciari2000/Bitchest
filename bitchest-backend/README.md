# BitChest Backend

Laravel backend API for the BitChest cryptocurrency trading platform.

## Features

- User authentication (Register, Login, Logout)
- Portfolio management
- Transaction handling (Buy/Sell cryptocurrencies)
- Market data API
- Admin dashboard endpoints
- MongoDB database integration

## Requirements

- PHP 8.2 or higher
- Composer
- MongoDB Atlas account or local MongoDB instance

## Installation

1. Install dependencies:
```bash
composer install
```

2. Copy the environment file:
```bash
cp .env.example .env
```

3. Generate application key:
```bash
php artisan key:generate
```

4. Configure MongoDB connection in `.env`:
```env
DB_CONNECTION=mongodb
MONGODB_DSN=mongodb+srv://username:password@cluster.mongodb.net/bitchest_backend_database?retryWrites=true&w=majority
MONGODB_DATABASE=bitchest_backend_database
```

Or use individual connection parameters:
```env
MONGODB_HOST=your-cluster.mongodb.net
MONGODB_USERNAME=your-username
MONGODB_PASSWORD=your-password
MONGODB_DATABASE=bitchest_backend_database
MONGODB_AUTHENTICATION_DATABASE=admin
```

5. Publish Sanctum configuration (if needed):
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

6. Start the development server:
```bash
php artisan serve
```

## API Endpoints

### Authentication
- `POST /register` - Register a new user
- `POST /login` - Login user
- `POST /logout` - Logout user (requires auth)
- `GET /me` - Get authenticated user (requires auth)

### Market Data
- `GET /market` - Get all cryptocurrencies
- `GET /market/top?limit=10` - Get top cryptocurrencies
- `GET /market/{symbol}` - Get specific cryptocurrency

### Portfolio
- `GET /portfolio` - Get user's portfolio (requires auth)
- `GET /portfolio/summary` - Get portfolio summary (requires auth)

### Transactions
- `GET /transactions` - Get user's transactions (requires auth)
- `POST /transactions` - Create a new transaction (requires auth)
- `GET /transactions/statistics` - Get transaction statistics (requires auth)

### Admin
- `GET /admin/users` - Get all users (requires admin)
- `GET /admin/statistics` - Get platform statistics (requires admin)
- `GET /admin/transactions` - Get all transactions (requires admin)
- `PUT /admin/users/{userId}/status` - Update user status (requires admin)

## Authentication

The API uses Laravel Sanctum for authentication. Include the token in the Authorization header:

```
Authorization: Bearer {token}
```

## Database Collections

- `users` - User accounts
- `transactions` - Transaction history
- `portfolios` - User cryptocurrency holdings
- `cryptos` - Cryptocurrency market data

## Notes

- MongoDB Atlas connection string format: `mongodb+srv://username:password@cluster.mongodb.net/database?retryWrites=true&w=majority`
- Make sure to whitelist your IP address in MongoDB Atlas
- Update `SANCTUM_STATEFUL_DOMAINS` in `.env` to include your frontend domain
