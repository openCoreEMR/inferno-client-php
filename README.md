# Inferno API PHP Client

This is a PHP client for interacting with the Inferno API as defined in the `swagger.yml` specification. It includes strongly-typed data models that match the API definitions.

## Features

* Strongly-typed API client with proper model classes for all API endpoints
* Complete implementation of all endpoints defined in the Swagger specification
* Error handling and response parsing

## Usage

### Basic Setup

```php
require_once 'InfernoClient.php';

// Create a new client instance
$client = new InfernoClient(
    'localhost',    // Host name (default: localhost)
    4567,           // Port number (default: 80)
    false           // Use HTTPS (default: false)
);
```

### API Methods with Type Safety

The client provides methods that correspond to all endpoints in the Inferno API, with proper return types:

#### Test Suite Operations

```php
// Get all test suites
$testSuites = $client->getTestSuites(); // Returns an array of TestSuite objects

// Get a specific test suite
$testSuite = $client->getTestSuite($testSuiteId); // Returns a TestSuite object

// Get requirements for a test suite
$requirements = $client->getTestSuiteRequirements($testSuiteId, $sessionId); // Returns an array of Requirement objects

// Check configuration for a test suite
$configMessages = $client->checkTestSuiteConfiguration($testSuiteId); // Returns an array of Message objects
```

#### Test Session Operations

```php
// Create a new test session
$testSession = $client->createTestSession($testSuiteId, $presetId); // Returns a TestSession object

// Get an existing test session
$testSession = $client->getTestSession($testSessionId); // Returns a TestSession object

// Get results for a test session
$results = $client->getTestSessionResults($testSessionId, $all); // Returns an array of Result objects

// Get session data
$sessionData = $client->getSessionData($testSessionId); // Returns an array of SessionData objects

// Apply preset inputs to a test session
$success = $client->applySessionDataPreset($testSessionId, $presetId); // Returns a boolean
```

#### Test Run Operations

```php
// Execute a test run
$testRun = $client->createTestRun([
    'test_session_id' => $testSessionId,
    'test_suite_id' => $testSuiteId,
    'inputs' => [
        ['name' => 'param1', 'value' => 'value1'],
        ['name' => 'param2', 'value' => 'value2']
    ]
]); // Returns a TestRun object

// Get a test run
$testRun = $client->getTestRun($testRunId, $includeResults, $after); // Returns a TestRun object

// Cancel a test run
$canceledRun = $client->cancelTestRun($testRunId); // Returns a TestRun object

// Get the last test run for a session
$lastRun = $client->getLastTestRun($testSessionId); // Returns a TestRun object

// Get results for a test run
$results = $client->getTestRunResults($testRunId); // Returns an array of Result objects
```

#### Other Operations

```php
// Get details of a request
$request = $client->getRequest($requestId); // Returns a Request object

// Get a requirement
$requirement = $client->getRequirement($requirementId); // Returns a Requirement object

// Get Inferno version
$version = $client->getVersion(); // Returns a Version object
```

## Error Handling

The client throws exceptions when API requests fail. Catch these exceptions to handle errors:

```php
try {
    $testSuites = $client->getTestSuites();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Example

See the `inferno_client_example.php` file for a complete example of using the client.

## Model Classes

The client includes the following model classes that match the API definitions:

* `Version` - Inferno version information
* `Message` - Message from the Inferno API
* `SessionData` - Session data
* `PresetSummary` - Summary of a preset
* `Input` - Input for a test, test group, or test suite
* `SuiteOption` - Option for a test suite
* `RequestSummary` - Summary of a request
* `Request` - Detailed request information
* `Result` - Result of a test run
* `Requirement` - Requirement for a test
* `Test` - Test information
* `TestGroup` - Group of tests
* `TestSuite` - Suite of tests
* `TestRun` - Test run information
* `TestSession` - Test session information

## License

This client is released under the Apache 2.0 license, following the license of the Inferno API.
