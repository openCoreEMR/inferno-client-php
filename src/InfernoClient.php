<?php

/**
 * Inferno API Client
 *
 * A PHP client for interacting with the Inferno API as defined in swagger.yml
 *
 * @version 0.1.1
 * @license Apache 2.0
 */

// Include model classes
require_once __DIR__ . '/models/autoload.php';

class InfernoClient
{
    /** @var string The base URL for the API */
    private $baseUrl;

    /** @var array Default request options */
    private $options;

    /**
     * Constructor
     *
     * @param string $host The host name (default: localhost)
     * @param int $port The port number (default: 80)
     * @param bool $useHttps Whether to use HTTPS (default: false)
     * @param array $options Additional request options
     */
    public function __construct(
        string $host = 'localhost',
        int $port = 80,
        bool $useHttps = false,
        array $options = []
    ) {
        $scheme = $useHttps ? 'https' : 'http';
        $this->baseUrl = "{$scheme}://{$host}";

        if (($useHttps && $port !== 443) || (!$useHttps && $port !== 80)) {
            $this->baseUrl .= ":{$port}";
        }

        $this->baseUrl .= '/api';
        $this->options = $options;
    }

    /**
     * Make a request to the Inferno API
     *
     * @param string $method The HTTP method
     * @param string $endpoint The API endpoint
     * @param array $params Query parameters
     * @param array $data Request body data
     * @return array The response data
     * @throws Exception If the request fails
     */
    private function request(string $method, string $endpoint, array $params = [], array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if (!empty($data)) {
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            ]);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode >= 400) {
            throw new Exception('API Error: ' . ($responseData['message'] ?? 'Unknown error'), $httpCode);
        }

        return $responseData;
    }    /**
     * Get all test suites
     *
     * @return TestSuite[] List of test suites
     */
    public function getTestSuites(): array
    {
        $response = $this->request('GET', '/test_suites');
        return TestSuite::fromArrayCollection($response);
    }

    /**
     * Get a specific test suite by ID
     *
     * @param string $testSuiteId The test suite ID
     * @return TestSuite The test suite
     */
    public function getTestSuite(string $testSuiteId): TestSuite
    {
        $response = $this->request('GET', "/test_suites/{$testSuiteId}");
        return TestSuite::fromArray($response);
    }

    /**
     * Get requirements for a test suite
     *
     * @param string $testSuiteId The test suite ID
     * @param string|null $sessionId The session ID (optional)
     * @return Requirement[] The requirements
     */
    public function getTestSuiteRequirements(string $testSuiteId, ?string $sessionId = null): array
    {
        $params = [];
        if ($sessionId !== null) {
            $params['session_id'] = $sessionId;
        }

        $response = $this->request('GET', "/test_suites/{$testSuiteId}/requirements", $params);
        return Requirement::fromArrayCollection($response);
    }    /**
     * Check the configuration for a test suite
     *
     * @param string $testSuiteId The test suite ID
     * @return Message[] Configuration messages
     */
    public function checkTestSuiteConfiguration(string $testSuiteId): array
    {
        $response = $this->request('PUT', "/test_suites/{$testSuiteId}/check_configuration");
        return Message::fromArrayCollection($response);
    }

    /**
     * Start a new test session
     *
     * @param string $testSuiteId The test suite ID
     * @param string|null $presetId The preset ID (optional)
     * @return TestSession The created test session
     */
    public function createTestSession(string $testSuiteId, ?string $presetId = null): TestSession
    {
        $params = ['test_suite_id' => $testSuiteId];

        if ($presetId !== null) {
            $params['preset_id'] = $presetId;
        }

        $response = $this->request('POST', '/test_sessions', $params);
        return TestSession::fromArray($response);
    }

    /**
     * Get an existing test session
     *
     * @param string $testSessionId The test session ID
     * @return TestSession The test session
     */
    public function getTestSession(string $testSessionId): TestSession
    {
        $response = $this->request('GET', "/test_sessions/{$testSessionId}");
        return TestSession::fromArray($response);
    }

    /**
     * Get results for a test session
     *
     * @param string $testSessionId The test session ID
     * @param bool $all Whether to retrieve all results (default: false)
     * @return Result[] The results
     */
    public function getTestSessionResults(string $testSessionId, bool $all = false): array
    {
        $params = [];
        if ($all) {
            $params['all'] = 'true';
        }

        $response = $this->request('GET', "/test_sessions/{$testSessionId}/results", $params);
        return Result::fromArrayCollection($response);
    }    /**
     * Get session data for a test session
     *
     * @param string $testSessionId The test session ID
     * @return SessionData[] The session data
     */
    public function getSessionData(string $testSessionId): array
    {
        $response = $this->request('GET', "/test_sessions/{$testSessionId}/session_data");
        return SessionData::fromArrayCollection($response);
    }

    /**
     * Apply preset inputs to a test session
     *
     * @param string $testSessionId The test session ID
     * @param string $presetId The preset ID
     * @return bool Success status
     */
    public function applySessionDataPreset(string $testSessionId, string $presetId): bool
    {
        $this->request('GET', "/test_sessions/{$testSessionId}/session_data/apply_preset", ['preset_id' => $presetId]);
        return true;
    }

    /**
     * Execute a suite, group, or test
     *
     * @param array $testRun The test run configuration
     * @return TestRun The created test run
     */
    public function createTestRun(array $testRun): TestRun
    {
        $response = $this->request('POST', '/test_runs', [], $testRun);
        return TestRun::fromArray($response);
    }

    /**
     * Get an existing test run
     *
     * @param string $testRunId The test run ID
     * @param bool $includeResults Whether to include results (default: false)
     * @param string|null $after Only include results from this time (ISO8601 format)
     * @return TestRun The test run
     */
    public function getTestRun(string $testRunId, bool $includeResults = false, ?string $after = null): TestRun
    {
        $params = [];

        if ($includeResults) {
            $params['include_results'] = 'true';
        }

        if ($after !== null) {
            $params['after'] = $after;
        }

        $response = $this->request('GET', "/test_runs/{$testRunId}", $params);
        return TestRun::fromArray($response);
    }    /**
     * Cancel an existing test run
     *
     * @param string $testRunId The test run ID
     * @return TestRun The canceled test run
     */
    public function cancelTestRun(string $testRunId): TestRun
    {
        $response = $this->request('DELETE', "/test_runs/{$testRunId}");
        return TestRun::fromArray($response);
    }

    /**
     * Get the most recent test run for a session
     *
     * @param string $testSessionId The test session ID
     * @return TestRun The test run
     */
    public function getLastTestRun(string $testSessionId): TestRun
    {
        $response = $this->request('GET', "/test_sessions/{$testSessionId}/last_test_run");
        return TestRun::fromArray($response);
    }

    /**
     * Get results for a test run
     *
     * @param string $testRunId The test run ID
     * @return Result[] The results
     */
    public function getTestRunResults(string $testRunId): array
    {
        $response = $this->request('GET', "/test_runs/{$testRunId}/results");
        return Result::fromArrayCollection($response);
    }

    /**
     * Get the details of a request and response
     *
     * @param string $requestId The request ID
     * @return Request The request details
     */
    public function getRequest(string $requestId): Request
    {
        $response = $this->request('GET', "/request/{$requestId}");
        return Request::fromArray($response);
    }

    /**
     * Get a single requirement
     *
     * @param string $requirementId The requirement ID
     * @return Requirement The requirement
     */
    public function getRequirement(string $requirementId): Requirement
    {
        $response = $this->request('GET', "/requirements/{$requirementId}");
        return Requirement::fromArray($response);
    }

    /**
     * Get the version of Inferno
     *
     * @return Version The version information
     */
    public function getVersion(): Version
    {
        $response = $this->request('GET', '/version');
        return Version::fromArray($response);
    }
}
