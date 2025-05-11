# Hypervel Response Formatter

A simple and reusable package to standardize API response formats in Hypervel framework applications. This package provides utilities to format success and error responses consistently, along with a middleware to automate response formatting.

## Features
- Standardized JSON response structure for success and error cases.
- Configurable status labels and case styles (camelCase or snake_case).
- Middleware for automatic response formatting.
- Clean, maintainable, and tested code.

## Requirements
- PHP >= 8.1
- Hypervel framework

## Installation

1. Install the package via Composer:
   ```bash
   composer require giatechindo/hypervel-response-formatter
   ```

2. Publish the configuration file (optional):
   ```bash
   php hypervel config:publish response-formatter
   ```

3. Register the middleware in your Hypervel application (e.g., in `app/Http/Kernel.php`):
   ```php
   protected $middleware = [
       \Giatechindo\HypervelResponseFormatter\Middleware\FormatResponseMiddleware::class,
   ];
   ```

## Configuration

The configuration file is located at `config/response-formatter.php`. You can customize the following options:

```php
return [
    'status_success' => 'success', // Label for success responses
    'status_error' => 'error',     // Label for error responses
    'case_style' => 'camelCase',   // or 'snake_case'
];
```

## Usage

### Formatting a Success Response
```php
use Giatechindo\HypervelResponseFormatter\ResponseFormatter;

return ResponseFormatter::success(['id' => 1, 'name' => 'John'], 'Data retrieved', 200);
```

Output:
```json
{
    "status": "success",
    "code": 200,
    "message": "Data retrieved",
    "data": {
        "id": 1,
        "name": "John"
    }
}
```

### Formatting an Error Response
```php
use Giatechindo\HypervelResponseFormatter\ResponseFormatter;

return ResponseFormatter::error('Invalid input', 400, ['field' => 'required']);
```

Output:
```json
{
    "status": "error",
    "code": 400,
    "message": "Invalid input",
    "errors": {
        "field": "required"
    }
}
```

### Using the Middleware
When the middleware is registered, all responses will be automatically formatted as success responses unless they are already formatted.

## Testing

Run the unit tests using PHPUnit:
```bash
composer test
```

## Contributing

Contributions are welcome! Please submit a pull request or open an issue on the [GitHub repository](https://github.com/giatechindo/hypervel-response-formatter).

## License

This package is open-sourced under the [MIT License](LICENSE).