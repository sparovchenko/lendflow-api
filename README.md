# Lendflow API - NYT Best Sellers Wrapper

This Laravel-based API acts as a wrapper for the New York Times Best Sellers History API. It provides a versioned JSON endpoint to retrieve best seller data based on various query parameters.

## Table of Contents

- [Project Structure](#project-structure)
- [Clone the Repository](#clone-the-repository)
- [Setting Up the Development Environment](#setting-up-the-development-environment)
- [Static Analysis & Code Formatting](#static-analysis--code-formatting)
- [Testing](#testing)
- [To be Enhanced](#to-be-enhanced)
- [Additional Notes](#additional-notes)

## Project Structure

```bash
lendflow-api/
    ├── app/
    │   ├── InternalAPI/
    │   │   └── Actions
    │   │   │   └── BestSellerAction.php
    │   │   └── Exceptions
    │   │   │   └── NYTApiException.php
    │   │   └── Integrations
    │   │   │   ├── ClientInterface.php
    │   │   │   └── NYTClient.php
    │   │   └── Requests
    │   │   │   └── BestSellerFormRequest.php
    │   │   └── Resources
    │   │   │   └── BestSellerResource.php
    │   │   └── Services
    │   │   │   └── BestSellerService.php
    │   └── Providers/
    │   │   └── AppServiceProvider.php
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── docker/
    │   ├── common/
    │   │   └── php-fpm/
    │   │       └── Dockerfile
    │   ├── development/
    │   │   ├── php-fpm/
    │   │   │   └── entrypoint.sh
    │   │   ├── workspace/
    │   │   │   └── Dockerfile
    │   │   └── nginx
    │   │       ├── Dockerfile
    │   │       └── nginx.conf
    │   └── production/
    ├── public/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── tests/
    ├── vendor/
    ├── .env
    ├── .env.example
    ├── .gitattributes
    ├── .gitignore
    ├── artisan
    ├── compose.dev.yaml
    ├── composer.json
    ├── composer.lock
    ├── package.json
    ├── phpstan.neon
    ├── phpunit.xml
    ├── phpunipint.json
    ├── README.md
    ├── vite.config.js
```

## Clone the Repository

```bash
git clone https://github.com/yourusername/lendflow-api.git
cd lendflow-api
```

## Setting Up the Development Environment

1. Copy the .env.example file to .env and set NYT API Credentials:

```bash
cp .env.example .env

LENDFLOW_NYT_API_KEY=
LENDFLOW_NYT_BASE_URL_FOR_BOOKS=
```

2. Start the Docker Compose Services:

```bash
docker-compose -f compose.dev.yaml up -d
```

3. Generate APP KEY:

```bash
docker-compose -f compose.dev.yaml exec workspace php artisan key:generate
```

4. Install Laravel Dependencies:

```bash
docker-compose -f compose.dev.yaml exec workspace composer install
```

5. Access the Application:

Open your browser and navigate to [http://localhost:8080](http://localhost:8080).

## Static Analysis & Code Formatting

*Laravel Pint (Code Style)*

```bash
docker-compose -f compose.dev.yaml exec workspace composer format
```

*PHPStan / Larastan (Static Analysis)*

```bash
docker-compose -f compose.dev.yaml exec workspace composer analyze
```

## Testing

```bash
docker-compose -f compose.dev.yaml exec workspace php artisan test
```

## To be Enhanced

### CI/CD

It is recommended to integrate CI/CD to run tests automatically on each commit.

### User Authentication & Authorization

It would be great to integrate user authentication and authorization to secure the API. This enhancement would:

* Ensure only authorized users can trigger the endpoint.
* Allow for more granular control over access to different parts of the API.
* Include additional request validations based on the authenticated user's permissions.

## Additional Notes

### Rate Limiting

Rate limiting is applied to protect the API. Check RouteServiceProvider or middleware configurations for details.

### Caching

API responses are cached for one hour to improve performance and reduce external API calls.

### Code Standards

This project follows OOP, SOLID, DRY and KISS principles, as well as PSR standards. Contributions should adhere to these guidelines.