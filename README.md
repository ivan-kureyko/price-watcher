# Price Watcher
A simple Laravel service for tracking price changes on OLX listings.
Users can subscribe to a listing using an email address. The service periodically checks listing prices and sends email notifications when a price changes.

## Features
- Subscribe to an OLX listing
- REST API endpoint for creating subscriptions
- Simple web form for creating subscriptions
- Stores listings and subscribers in a database
- Periodic price checks using Laravel Scheduler
- Background processing using Laravel Queues
- Email notifications when a price changes
- Prevents duplicate subscriptions for the same listing and email

# Architecture

## Subscription Flow
![Subscription Flow](subscription-flow.svg)

## Price Monitoring Flow
![Price Monitoring Flow](price-monitoring-flow.svg)

## Tech Stack

- PHP 8.3
- Laravel 13
- MySQL
- Docker
- Laravel Scheduler
- Laravel Queues
- Mailhog

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd price-watcher

docker compose up -d  - Start containers

docker compose exec app composer install - Install dependencies

docker compose exec app php artisan migrate - Run migrations
```

## Running the Application

```text
http://price-watcher.local:8080 - Application URL

http://localhost:8025 - Mailhog
```

## Commands

```bash
docker compose exec app php artisan queue:work - Start queue worker

docker compose exec app php artisan schedule:work - Run scheduler
```

## API

### Create Subscription

POST `/api/subscriptions`

Request body:

```json
{
    "email": "test@example.com",
    "url": "https://www.olx.ua/d/..."
}
```

Response:

```json
{
    "message": "Subscription created successfully"
}
```

## How It Works

1. User creates a subscription through the web form or API.
2. The service stores the listing and subscription in the database.
3. Laravel Scheduler periodically runs the `prices:dispatch-checks` command.
4. The command dispatches one `CheckListingsPricesJob`. This job loads all tracked listings and checks them one by one. WithoutOverlapping middleware prevents another price-check job from running before the current one finishes.
5. The job downloads the OLX page and extracts the current price.
6. If the price changes, email notifications are sent to all subscribers of that listing.

## Known Limitations

- The parser relies on the current OLX page structure.
- If OLX changes its JSON-LD structure, the parser may require updates.
- The project was created as a test assignment and is not intended for production use without additional infrastructure and monitoring.