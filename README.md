# Hypervel Response Formatter

[![Latest Version](https://img.shields.io/packagist/v/giatechindo/hypervel-response-formatter.svg?style=flat-square)](https://packagist.org/packages/giatechindo/hypervel-response-formatter)
[![Total Downloads](https://img.shields.io/packagist/dt/giatechindo/hypervel-response-formatter.svg?style=flat-square)](https://packagist.org/packages/giatechindo/hypervel-response-formatter)
[![License](https://img.shields.io/packagist/l/giatechindo/hypervel-response-formatter.svg?style=flat-square)](https://packagist.org/packages/giatechindo/hypervel-response-formatter)

Standardized API response formatter for Hypervel framework with PCOV coverage support.

## Features

- Consistent JSON response structure
- Success and error response helpers
- PSR-7 compatible responses
- Built-in test coverage support
- IDE-friendly method chaining

- Testing di Project
- `https://github.com/Giatechindo/hypervel-testing`

## Installation

```bash
composer require giatechindo/hypervel-response-formatter
```

## 📺 Playlist

Berikut adalah playlist video pembelajaran yang dapat Anda ikuti:

🔗 [Klik di sini untuk membuka playlist di YouTube](https://www.youtube.com/playlist?list=PLusb1og4k-lp4W-XTA_u_wuhqRrmRugiJ)


## Configuration

The package auto-registers itself. For manual configuration:

```php
// config/autoload/dependencies.php
return [
    'dependencies' => [
        'invokables' => [
            \Giatechindo\HypervelResponseFormatter\ResponseFormatter::class => \Giatechindo\HypervelResponseFormatter\ResponseFormatter::class,
        ],
    ],
];
```

## Usage

### Basic Responses

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Giatechindo\HypervelResponseFormatter\ResponseFormatter;
use Hyperf\HttpServer\Contract\ResponseInterface;

class UserController
{
    public function index(ResponseInterface $response)
    {
        $users = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
        ];
        return (new ResponseFormatter($response))->success($users, 'Users retrieved successfully', 200);
    }

    public function show(ResponseInterface $response)
    {
        return (new ResponseFormatter($response))->error('User not found', ['id' => 'Invalid ID'], 404);
    }
}
```

### Success Response

```php
return response()->success(
    data: ['id' => 1, 'name' => 'John'],
    message: 'User retrieved', 
    statusCode: 200
);
```

Response:

```json
{
    "success": true,
    "message": "User retrieved",
    "data": {
        "id": 1,
        "name": "John"
    }
}
```

### Error Response

```php
return response()->error(
    message: 'Validation failed',
    errors: ['email' => 'Invalid format'],
    statusCode: 422
);
```

Response:

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": "Invalid format"
    }
}
```

### Without Data/Errors

```php
return response()->success(message: 'Operation completed');
return response()->error(message: 'Not found', statusCode: 404);
```

## Response Structure

### Success

```json
{
    "success": true,
    "message": "string",
    "data": {} // optional
}
```

### Error

```json
{
    "success": false,
    "message": "string",
    "errors": {} // optional
}
```

## Testing

```bash
# Install PCOV for coverage (Ubuntu)
sudo apt-get install php8.3-pcov

# Run tests with coverage
vendor/bin/phpunit --coverage-html coverage

# View coverage report
xdg-open coverage/index.html
```

## Development Setup

Clone repository:

```bash
git clone git@github.com:Giatechindo/hypervel-response-formatter.git
```

Install dependencies:

```bash
composer install
```

Run tests:

```bash
composer test
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

MIT

Giatechindo Community - [GitHub](https://github.com/Giatechindo) | [Packagist](https://packagist.org/packages/giatechindo/hypervel-response-formatter)

## Download Options

1. **Copy-paste** the above content into a new `README.md` file
2. **Or** download directly using:

```bash
curl -o README.md https://gist.githubusercontent.com/raw/...  # Replace with actual URL if uploaded
```

This documentation includes:

- All working features from our implementation
- Installation instructions
- Usage examples
- Response structures
- Testing setup with PCOV
- Development guidelines
- Contribution info
