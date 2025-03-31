# Lendflow API - NYT Best Sellers Wrapper

This Laravel-based API acts as a wrapper for the New York Times Best Sellers History API. It provides a versioned JSON endpoint to retrieve best seller data based on various query parameters.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Project Structure](#project-structure)
- [Running the Application](#running-the-application)
- [Testing](#testing)
- [To be Enhanced](#to-be-enhanced)
- [Additional Notes](#additional-notes)

## Requirements

- PHP 8.0 or above
- Composer
- A web server (e.g., Apache, Nginx) or PHP's built-in server
- Laravel 9 (or your project version)

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/yourusername/lendflow-api.git
   cd lendflow-api
   ```

2. **Install Dependencies**

    ```bash
    composer install
    ```

3. **Copy .env File**

    *Copy the example environment file and set your local environment variables:*

    ```bash
    cp .env.example .env
    ```

4. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

## Configuration

*In your .env file, add your New York Times API credentials and base URL:*

    ```bash
    LENDFLOW_NYT_API_KEY=
    LENDFLOW_NYT_BASE_URL_FOR_BOOKS=
    ```

## Project Structure

    ```bash
    app/
    └── InternalAPI/
        └── V1/
            └── Books/
                ├── Actions/
                │    └── BestSellerAction.php
                ├── Integrations/
                │    ├── ClientInterface.php
                │    └── NYTClient.php
                ├── Requests/
                │    └── BestSellerFormRequest.php
                ├── Resources/
                │    └── BestSellerResource.php
                └── Servises/
                    └── BestSellerService.php
    config/
    └── services.php
    routes/
    ├── api.php
    └── web.php
    tests/
    └── Feature/
        └── ExampleTest.php  // Pest tests for the API
    ```

## Running the Application

*To start the Laravel development server, run:*

```bash
php artisan serve
```

## Testing

*This project uses Pest for testing along with Laravel's testing helpers.*

1. Run All Tests

```bash
./vendor/bin/pest
```

2. Key Testing Features:

    HTTP Client Faking:
    * Tests use Laravel's Http::fake() and Http::preventStrayRequests() to simulate API responses without making real HTTP requests.

    Mocking with Mockery:
    * Tests also include examples of using Mockery to substitute the NYTClient in the service layer.

    Validation and Edge Cases:
    * Tests cover validation errors, edge cases, and proper error handling when the NYT API fails.

## To be Enhanced

    * CI/CD:
        It is recommended to integrate CI/CD to run tests automatically on each commit.

    * User Authentication & Authorization:
        It would be great to integrate user authentication and authorization to secure the API. This enhancement would:
            * Ensure only authorized users can trigger the endpoint.
            * Allow for more granular control over access to different parts of the API.
            * Include additional request validations based on the authenticated user's permissions.

## Additional Notes

    * Rate Limiting:
        Rate limiting is applied to protect the API. Check RouteServiceProvider or middleware configurations for details.

    * Caching:
        API responses are cached for one hour to improve performance and reduce external API calls.

    * Code Standards:
        This project follows OOP, SOLID, DRY, KISS, and YAGNI principles, as well as PSR standards. Contributions should adhere to these guidelines.