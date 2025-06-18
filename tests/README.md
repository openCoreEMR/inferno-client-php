# Inferno Client PHP Tests

This directory contains unit tests for the Inferno API PHP Client. The tests validate that the client methods align with the API endpoints defined in the swagger.yml specification.

## Test Structure

- `InfernoClientTest.php` - Tests for all API methods in the InfernoClient class
- `InfernoClientRequestTest.php` - Tests for the request method and error handling
- `ModelDefinitionsTest.php` - Tests to ensure model properties align with swagger.yml definitions

## Running Tests

You can run the tests using PHPUnit:

```bash
vendor/bin/phpunit
```

## Test Coverage

The tests cover:

1. API endpoint mappings - Validating that client methods correctly map to swagger.yml endpoints
2. Request parameter handling - Ensuring parameters are passed correctly to the API
3. Response handling - Verifying that responses are parsed into the appropriate model objects
4. Error handling - Testing that API errors are properly caught and handled
5. Model definitions - Confirming that model properties match the swagger.yml schemas

## Adding New Tests

When adding new tests:

1. For new API endpoints, add tests to `InfernoClientTest.php`
2. For model changes, update `ModelDefinitionsTest.php`
3. For request handling changes, update `InfernoClientRequestTest.php`
