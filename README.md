# Api de Ingressos

Api de Ingressos is a PHP-based application designed to facilitate the sale of event tickets. The application supports different permission levels, allowing promoters to register events and ticket batches for sale, while clients can purchase tickets. The payment integration is handled through Stripe.

## Features

- **Event Management**: Promoters can create and manage events.
- **Ticket Sales**: Promoters can create ticket batches for sale.
- **User Permissions**: Two levels of permissions - PROMOTOR and CLIENTE.
- **Payment Integration**: Seamless integration with Stripe for secure payments.

## Getting Started

### Prerequisites

Ensure you have the following installed:

- PHP
- Composer

### Installation

1. Clone the repository:
```ssh
git clone git@github.com:walker007/ingressos.git
cd ingressos
```
2. Install dependencies:
```ssh
composer install
```
3. Configure environment variables:
    - Database connection details
    - Stripe API key
Update the .env file accordingly.

4. Serve the application:
```ssh
php artisan serve
```
## Built With
- Laravel - The PHP framework used
## Environment Variables
The environment variables need to be set are in .env.example file.
